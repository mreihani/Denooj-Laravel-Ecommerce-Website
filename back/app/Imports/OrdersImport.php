<?php

namespace App\Imports;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Orders\Entities\Order;
use Modules\Products\Entities\Product;
use Modules\Users\Entities\City;
use Modules\Users\Entities\User;
use Modules\Users\Entities\UserPayment;

class OrdersImport extends Controller implements ToModel, WithHeadingRow
{
    private $rows = 0, $rejectedRows = 0, $importedRows = 0;

    /**
     * @param array $row
     *
     * @return Model|null
     */

    public function model(array $row)
    {
        // check correct file format
        $requiredFields = ['order_number', 'order_id', 'customer_id'];
        if (!empty(array_diff($requiredFields, array_keys($row)))) {
            return null;
        }

        ++$this->rows;

        // check required parameters
        if (empty($row['order_id']) || empty($row['customer_id']) || empty($row['order_number'])) {
            ++$this->rejectedRows;
            return null;
        }


        // check status
        $status = $row['status'];
        switch ($status) {
            case "completed":
                $status = 'completed';
                break;
            case "processing":
                $status = 'ongoing';
                break;
            case "pending":
            case "on-hold":
                $status = 'pending_payment';
                break;
            default:
                $status = 'cancel';
        }

        // prices and payments
        $price = intval($row['order_subtotal']);
        $paidPrice = intval($row['order_total']);
        $shippingCost = intval($row['shipping_total']);
        $isPaid = (bool)$row['paid_date'];

        // get payment method
        $paymentMethod = $row['payment_method'];
        switch ($paymentMethod) {
//            case "WC_ZPal":
//            case "zarinpaldargahplus":
//                $paymentMethod = 'zarinpal';
//                break;
            case "WC_IDPay":
                $paymentMethod = 'idpay';
                break;
            default:
                $paymentMethod = 'zarinpal';
                break;
        }

        // address
        $shippingAddress = !empty($row['billing_address_1']) ? $row['billing_address_1'] : $row['billing_address_2'];
        $shippingPostCode = $row['billing_postcode'] ?? '6666666666';
        $shippingPhone = $row['billing_phone'] ?? '00000000000';
        $shippingFullName = $row['billing_first_name'] . ' ' . $row['billing_last_name'];
        $shippingCity = $row['billing_state'];
        $city = City::where('name', $shippingCity)->orWhere('name', 'like', '%' . $shippingCity . '%')->first();
        if (!$city) {
            $city = City::find(655);
        }
        $province = $city->province;

        // get products from order items
        $productsArray = [];
        foreach ($row as $key => $rowItem) {
            if (str_starts_with($key,'line_item_') && !empty($rowItem)){
                // order item row
                $productObj = [];
                $itemArray = explode('|', $rowItem);
                foreach ($itemArray as $keyValueItem){
                    $keyVal = explode(':',$keyValueItem);
                    if (count($keyVal) > 1){
                        $key = $keyVal[0];
                        $val = $keyVal[1];
                        $productObj[$key] = $val;
                    }
                }
                array_push($productsArray,$productObj);
            }
        }

        // break import if user not found
        $user = User::find($row['customer_id']);
        if (!$user){
            ++$this->rejectedRows;
            return null;
        }

        // check order exists
        $order = Order::where('order_number',$row['order_number'])->first();
        if (!$order){
            // create order
            $order = Order::create([
                'user_id' => $row['customer_id'],
                'order_number' => $row['order_number'],
                'status' => $status,
                'price' => $price,
                'paid_price' => $paidPrice,
                'is_paid' => $isPaid,
                'payment_method' => $paymentMethod,
                'notes' => $row['customer_note'] ?? null,
                'shipping_address' => $shippingAddress ?? '--',
                'shipping_province' => $province,
                'shipping_city' => $city->id,
                'shipping_post_code' => $shippingPostCode,
                'shipping_phone' => $shippingPhone,
                'shipping_full_name' => $shippingFullName,
                'shipping_cost' => $shippingCost,
                'shipping_method' => 'post_pishtaz',
//            'coupons' => $row['order'],
//            'paid_from_wallet' => $row['order'],
                'discount' => $row['order_discount'],
                'created_at' => Carbon::make($row['order_date']),
                'completed_at' => Carbon::make($row['order_date'])
            ]);
        }


        // attach products to order
        foreach ($productsArray as $productObj) {

            // attach products to order
            $product = Product::find($productObj['product_id']);
            if ($product){
                $order->items()->attach($productObj['product_id'], [
                    'price' => $productObj['sub_total'],
                    'quantity' => $productObj['quantity']
                ]);
            }
        }


        // create payment model
        UserPayment::create([
            'user_id' => $row['customer_id'],
            'resnumber' => '0000000000',
            'order_id' => $order->id,
            'amount' => $paidPrice,
            'gateway' => $paymentMethod,
            'type' => 'order',
            'status' => $isPaid ? 'success' : 'failed'
        ]);

        ++$this->importedRows;
        return $order;

    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function getImportedRowCount(): int
    {
        return $this->importedRows;
    }

    public function getRejectedRowCount(): int
    {
        return $this->rejectedRows;
    }



}

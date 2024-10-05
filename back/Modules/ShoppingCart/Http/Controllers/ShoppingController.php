<?php

namespace Modules\ShoppingCart\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Products\Entities\Product;
use Modules\Settings\Entities\PaymentSetting;
use Modules\Settings\Entities\ShippingSettings;
use Modules\Users\Entities\Address;

class ShoppingController extends HelperController {

    public function calcShippingCost()
    {
        // find address
        $addressId = request('address_id');
      
        $address = Address::find($addressId);
        if (!$address) {
            return response([
                'success' => false,
                'msg' => 'آدرس پیدا نشد!'
            ]);
        }

        $selectedShippingMethod = request('selected_shipping_method');

        $priceToPay = cart()->getTotal();
        $items = cart()->getContent();

        if($selectedShippingMethod === 'initial') {
            $res = $this->calculateTotalShippingCost($address,$items);
        } else {
            $res = $this->calculateTotalShippingCostSelective($address,$items,$selectedShippingMethod);
        }

        $shippingCost = $res['shipping_cost'];
        $shippingMethod = $res['shipping_method'];
        $totalWeight = $res['total_weight'];
        $isCouponValid = $res['is_coupon_valid'];
        $totalPriceWithoutDiscount = $res['total_price_without_discount'];
        $totalDiscount = $res['total_discount'];

        $address = [
            'province' => $address->getProvince()->name,
            'city' => $address->getCity()->name,
            'post_code' => $address->post_code,
            'full_name' => $address->full_name,
            'phone' => $address->phone,
            'address' => $address->address,
        ];

        return response([
            'status' => 'success',
            'shipping_cost' => $shippingCost,
            'shipping_method' => $shippingMethod,
            'address' => $address,
            'price_to_pay' => $priceToPay + $shippingCost,
            'total_weight' => $totalWeight,
            'is_coupon_valid' => $isCouponValid,
            'total_price_without_discount' => $totalPriceWithoutDiscount,
            'total_discount' => $totalDiscount
        ]);
    }

    public function shipping()
    {
        if (session()->has('address_id')) {
            $address = Address::find(session('address_id'));
            $items = cart()->getContent();
            $shippingSettings = ShippingSettings::first();
            if ($address && $shippingSettings) {
                return view('shoppingcart::.shipping', compact('items', 'address', 'shippingSettings'));
            }
            return redirect(route('cart.address'));
        }
        return redirect(route('cart.address'));
    }

    public function checkout()
    {
        // check cart item
        if (cart()->getContent()->count() < 1 && empty($order)) {
            return redirect(route('cart'));
        }

        $items = cart()->getContent();

        // check cart item stock
        $deletedItemsHtml = "";
        foreach ($items as $item) {
            $rowArr = explode('_',$item->id);
            $inventoryId = null;
            if (count($rowArr) > 1){
                $inventoryId =$rowArr[1];
            }
            $product = Product::find($item->associatedModel->id);
            if (!$product || !$product->inStock() || $product->getStockQuantity($inventoryId) < $item->quantity){
                $deletedItemsHtml = "<p>برخی از آیتم های سبد خرید شما به دلیل تغییر در موجودی آنها، از سبد خرید شما حذف شدند.</p>";
                $deletedItemsHtml .= "<span>محصولات حذف شده: </span>";
                $deletedItemsHtml .= '<a class="m-2 d-inline-block fw-bold text-decoration-none" href="'.route('product.show',$item->associatedModel).'">"'.$item->associatedModel->title.'"</a>';
                cart()->remove($item->id);
            }
        }
        if (!empty($deletedItemsHtml)){
            session()->flash('warning', $deletedItemsHtml);
            return redirect(route('cart'));
        }

        $this->reloadCartItems();
        $this->checkCartConditions();

        $totalQuantity = cart()->getTotalQuantity();

        if (auth()->user()->addresses->count() > 0) {
            $address = auth()->user()->addresses()->first();
        } else {
            $address = null;
        }

        $balance = auth()->user()->balance;
        $totalDiscount = 0;
        foreach (cart()->getContent() as $item) {
            $rowArr = explode('_',$item->id);
            $inventoryId = null;
            if (count($rowArr) > 1){
                $inventoryId =$rowArr[1];
            }
            $totalDiscount += $item->associatedModel->getDiscountedPrice($inventoryId) * $item->quantity;
        }

        // get applied discount price
        $subTotal = cart()->getSubTotal();
        $conditions = cart()->getConditions();
        $totalAppliedDiscount = 0;
        foreach ($conditions as $condition){
            $totalAppliedDiscount += $condition->getCalculatedValue($subTotal);
        }

        $paymentSettings = PaymentSetting::firstOrCreate();
        $shippingSettings = ShippingSettings::firstOrCreate();

        // محاسبه وزن کل بر اساس برنج
        $totalWeight = 0;
        foreach ($items as $cartItem) {

            // جداسازی محصولات غیر برنج
            $categories = $cartItem->associatedModel->categories->pluck('id')->toArray();
            if(in_array(443, $categories)) {
                continue;
            }

            $totalItemWeight = intval($cartItem->associatedModel->weight) * $cartItem->quantity / 1000;
            $totalWeight += $totalItemWeight;
        }
        
        return view('shoppingcart::checkout', compact('paymentSettings','shippingSettings','totalAppliedDiscount','totalDiscount','items', 'address', 'totalQuantity','balance', 'totalWeight'));
    }

    public function reload(){
        $this->reloadCartItems();
        return redirect(route('cart'));
    }

    public function reloadCartItems()
    {
        $items = cart()->getContent();
        foreach ($items as $item) {
            $product = Product::find($item->associatedModel->id);
            if (!$product->inStock()) {
                cart()->remove($item->id);
            }
        }
    }

}

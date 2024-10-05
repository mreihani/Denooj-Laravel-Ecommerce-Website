<?php

namespace Modules\Orders\Http\Controllers;

use App\Jobs\SendMailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Shetabit\Multipay\Invoice;
use Modules\Admins\Entities\Admin;
use Modules\Orders\Entities\Order;
use Modules\Users\Entities\Address;
use Shetabit\Payment\Facade\Payment;
use App\Jobs\SendSmsOrderSubmittedJob;
use Modules\Products\Entities\Product;
use Illuminate\Support\Facades\Session;
use Modules\Users\Entities\UserPayment;
use App\Notifications\NewOrderSubmitted;
use App\Jobs\SendSmsAdminOrderCompletedJob;
use Modules\Products\Entities\ProductInventory;
use Modules\Settings\Entities\ShippingSettings;
use App\Jobs\SendSmsOrderSubmittedDenoojPostJob;
use App\Jobs\SendSmsOrderSubmittedDenooFourtyDaysJob;
use App\Jobs\SendSmsOrderSubmittedDenoojThreeDaysJob;
use App\Jobs\SendSmsOrderSubmittedDenooFifteenDaysJob;
use App\Jobs\SendSmsOrderSubmittedDenoojFreightageJob;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Modules\ShoppingCart\Http\Controllers\HelperController;
use App\Jobs\SendSmsOrderSubmittedDenoojFreightageCouponJob;

class OrderController extends HelperController
{
    function orderStoreStuff($inputs){

        // add coupons to order
        $coupons = [];
        foreach (cart()->getConditions() as $condition){
            array_push($coupons,$condition->getAttributes()['coupon_id']);
        }
        $inputs['coupons'] = $coupons;

        // get applied discount price
        $subTotal = cart()->getSubTotal();
        $conditions = cart()->getConditions();
        $discount = 0;
        foreach ($conditions as $condition){
            $discount += $condition->getCalculatedValue($subTotal);
        }
        $inputs['discount'] = $discount;


        // items discount
        $totalDiscount = 0;
        foreach (cart()->getContent() as $item) {
            $rowArr = explode('_',$item->id);
            $inventoryId = null;
            if (count($rowArr) > 1){
                $inventoryId =$rowArr[1];
            }

            $totalDiscount += $item->associatedModel->getDiscountedPrice($inventoryId) * $item->quantity;
        }
        $inputs['items_discount'] = $totalDiscount;


        // create order model
        $order = auth()->user()->orders()->create($inputs);

        foreach (cart()->getContent() as $item) {

            $rowId = explode('_',$item->id);
            $inventoryId = null;
            if (count($rowId) > 1){
                $inventoryId = $rowId[1];
            }
            $color = null;
            $size = null;

            if ($item['attributes']){
                if (array_key_exists('color',$item['attributes']->toArray()) && $item['attributes']['color']){
                    $color = $item['attributes']['color']['label'];
                }
                if (array_key_exists('size',$item['attributes']->toArray()) && $item['attributes']['size']){
                    $size = $item['attributes']['size']['label'];
                }
            }


            // attach products to order
            $order->items()->attach($item->associatedModel->id, [
                'price' => $item->price,
                'quantity' => $item->quantity,
                'color' => $color,
                'size' => $size,
            ]);

            // decrease product quantity
            if (!$inventoryId){
                if ($item->associatedModel->manage_stock){
                    $product = Product::find($item->associatedModel->id);
                    if ($product){
                        $product->update([
                            'stock' => $product->stock - $item->quantity
                        ]);
                    }
                }
            }else{
                $inventory = ProductInventory::find($inventoryId);
                if ($inventory){
                    if ($inventory->manage_stock){
                        $inventory->update([
                            'stock' => $inventory->stock - $item->quantity
                        ]);
                    }
                }
            }


        }



        // empty cart and clear coupons and sessions
        cart()->clear();
        cart()->clearCartConditions();
        session()->remove('shipping_method');
        session()->remove('address_id');

        return $order;
    }

    public function index()
    {
        $orders = auth()->user()->orders()->get();
        return view('orders::.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id == auth()->id()) {
            $shippingSettings = ShippingSettings::firstOrCreate();
            return view('orders::.show', compact('order','shippingSettings'));
        }
        return abort(403);
    }

    public function factor(Order $order){
        if (!$order->is_paid || $order->user->id != auth()->user()->id){
            if (!auth()->guard('admin')->check()){
                return abort(403);
            }
        }
        return view('orders::.factor',compact('order'));
    }

    public function update(Order $order)
    {
        request()->validate([
            'payment_method' => 'required',
            'gateway' => 'required',
        ]);

        $gateway = request('gateway');
        if (request('payment_method') === 'cash_on_delivery') {
            $gateway = null;
        }

        $order->update([
            'payment_method' => request('payment_method'),
            'gateway' => $gateway,
        ]);

        Session::flash('success', "تغییرات با موفقیت ذخیره شد.");
        return redirect()->back();
    }

    public function repay(Request $request,Order $order){
        $request->validate([
            'payment_method' => 'required'
        ]);

        // get payment settings
        $driverName = $request->payment_method;
        $gatewayRes = $this->checkGateways($driverName);
        if (!$gatewayRes['success']){
            session()->flash('error',$gatewayRes['msg']);
            return redirect()->back();
        }

        $user = auth()->user();
        $amount = $order->paid_price;
        $balance = $user->wallet->balance;

        // change order gateway
        $order->update([
            'payment_method' => $request->payment_method
        ]);

        // check wallet
        if ($order->paid_from_wallet != null){
            if (intval($order->paid_from_wallet) > intval($balance)){
                $amount = $order->price - $balance;
                $order->update([
                    'paid_from_wallet' => $balance,
                    'paid_price' => $amount
                ]);
            }
        }


        return Payment::via($driverName)->config($gatewayRes['config'])->purchase(
            (new Invoice)->amount($amount),
            function($driver, $transactionId) use ($amount,$user,$driverName,$order){
                $user->payments()->create([
                    'resnumber' => "$transactionId",
                    'order_id' => $order->id,
                    'amount' => $amount,
                    'gateway' => $driverName,
                    'type' => 'order'
                ]);
            }
        )->pay()->render();
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required',
            'payment_method' => 'required'
        ]);

        $inputs = $request->except('_token');
        $orderPrice = cart()->getSubTotalWithoutConditions();
        $paidPrice = cart()->getSubTotal();

        // check cart item
        $items = cart()->getContent();
        if ($items->count() < 1) {
            return redirect(route('home'));
        }


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


        // check for address exist
        $address = Address::find($request->address_id);
        if (!$address) {
            session()->flash('error', 'آدرس انتخابی شما پیدا نشد.');
            return redirect()->back();
        }

        // shipping info
//        $settings = ShippingSettings::first();
        $shippingRes = $this->calculateTotalShippingCost($address,cart()->getContent());
        $shippingCost = $shippingRes['shipping_cost'];
        $shippingMethod = $shippingRes['shipping_method'];
        $inputs['shipping_method'] = $shippingMethod;
        $inputs['shipping_cost'] = $shippingCost;

        // generate order number
        $orderNumber = Carbon::now()->year . Carbon::now()->month . '-' . rand(11111111, 99999999);
        $inputs['order_number'] = $orderNumber;

        // check tipax
        if ($request->has('tipax_check') && $request->tipax_check == 'on'){
            $inputs['shipping_method'] = 'tipax';
            $inputs['shipping_cost'] = 0;
        }else{
            // calculate order price
            $paidPrice += $shippingCost;
        }

        // wallet check
        $payAllAmountWithWallet = false;
        if (isset($request->wallet_check) && $request->wallet_check == 'on'){
            $balance = auth()->user()->balance;
            if ($balance > 0){
                if ($balance >= $paidPrice){
                    $inputs['paid_from_wallet'] = $paidPrice;
                    $payAllAmountWithWallet = true;
                }else{
                    $paidPrice -= $balance;
                    $inputs['paid_from_wallet'] = $balance;
                }
            }
        }
        $inputs['price'] = $orderPrice;
        $inputs['paid_price'] = $paidPrice;

        // address
        $inputs['shipping_address'] = $address->address;
        $inputs['shipping_province'] = $address->province;
        $inputs['shipping_city'] = $address->city;
        $inputs['shipping_post_code'] = $address->post_code;
        $inputs['shipping_phone'] = $address->phone;
        $inputs['shipping_full_name'] = $address->full_name;

        // get payment settings
        $driverName = $request->payment_method;
        $gatewayRes = $this->checkGateways($driverName);
        if (!$gatewayRes['success']){
            session()->flash('error',$gatewayRes['msg']);
            return redirect()->back();
        }

        // create order
        $order = $this->orderStoreStuff($inputs);
        $amount = $order->paid_price;
        $user = auth()->user();

        if (!$payAllAmountWithWallet){
            return Payment::via($driverName)->config($gatewayRes['config'])->purchase(
                (new Invoice)->amount($amount),
                function($driver, $transactionId) use ($amount,$user,$driverName,$order){
                    $user->payments()->create([
                        'resnumber' => "$transactionId",
                        'order_id' => $order->id,
                        'amount' => $amount,
                        'gateway' => $driverName,
                        'type' => 'order'
                    ]);
                }
            )->pay()->render();
        }else{
            $this->afterSuccessPaymentVerify($user,$order);
        }

        session()->flash('success','سفارش شما با موفقیت پرداخت و ثبت شد.');
        return redirect(route('order.show',$order));
    }

    public function zarinpalCallback(Request $request){
        $resnumber = $request->Authority;
        if($request->Status == 'OK'){
            return $this->afterSuccessPayment($resnumber);
        }
        return $this->afterFailedPayment($resnumber);
    }

    public function idpayCallback(Request $request){
        $resnumber = $request->id;
        if($request->status == '10'){
            return $this->afterSuccessPayment($resnumber);
        }
        return $this->afterFailedPayment($resnumber);
    }

    public function nextpayCallback(Request $request){
        $resnumber = $request->order_id;
        if(isset($request->np_status) && $request->np_status == "OK"){
            return $this->afterSuccessPayment($resnumber);
        }
        return $this->afterFailedPayment($resnumber);
    }

    public function pasargadCallback(Request $request){
        return $request;
        $resnumber = $request->order_id;
        if(isset($request->np_status) && $request->np_status == "OK"){
            return $this->afterSuccessPayment($resnumber);
        }
        return $this->afterFailedPayment($resnumber);
    }

    public function zibalCallback(Request $request){
        $resnumber = $request->trackId;
        if($request->success == 1){
            return $this->afterSuccessPayment($resnumber);
        }
        return $this->afterFailedPayment($resnumber);
    }

    public function parsianCallback(Request $request){
        $resnumber = $request->Token;
        if(isset($request->status) && $request->status == '0' && isset($request->Token)){
            return $this->afterSuccessPayment($resnumber);
        }
        return $this->afterFailedPayment($resnumber);
    }

    public function mellatCallback(Request $request){
        $resnumber = $request->RefId;
        if(isset($request->ResCode) && $request->ResCode == '0' && isset($request->RefId)){
            return $this->afterSuccessPayment($resnumber);
        }
        return $this->afterFailedPayment($resnumber);
    }

    public function afterFailedPayment($resnumber){
        $userPayment = UserPayment::where('user_id',auth()->id())->where('resnumber',$resnumber)->first();
        session()->flash('error','پرداخت انجام نشد!');

        if (!$userPayment || $resnumber == null || $resnumber == '' || !$userPayment->order){
            return redirect()->route('order.index');
        }

        return redirect()->route('order.show',$userPayment->order);
    }

    public function afterSuccessPayment($resnumber){
        $userPayment = UserPayment::where('user_id',auth()->id())->where('resnumber',$resnumber)->first();
        if ($userPayment){
            $driverName = $userPayment->gateway;
            $gatewayRes = $this->checkGateways($driverName);

            // verify payment
            try {
                $receipt = Payment::via($driverName)->config($gatewayRes['config'])
                    ->amount($userPayment->amount)->transactionId($resnumber)->verify();

                // update payment record
                $userPayment->update([
                    'status' => 'success',
                    'tracking_code' => $receipt->getReferenceId()
                ]);

                if ($userPayment->order){
                   $this->afterSuccessPaymentVerify($userPayment->user,$userPayment->order,$userPayment);
                }

                session()->flash('success','سفارش شما با موفقیت ثبت شد!');

            } catch (InvalidPaymentException $exception) {
                session()->flash('error',$exception->getMessage());
            }

            return redirect()->route('order.show',$userPayment->order);

        }else{
            session()->flash('error','رکورد پرداخت یافت نشد!');
            return redirect()->route('order.index');
        }
    }

    public function afterSuccessPaymentVerify($user,$order,$userPayment = null){
        $order->update([
            'is_paid' => true,
            'status' => 'ongoing'
        ]);

        // increase products sell count
        foreach ($order->items as $item) {
            $item->update([
                'sell_count' => intval($item->sell_count) + intval($item->pivot->quantity)
            ]);
        }

        // withdraw paid from wallet
        if ($order->paid_from_wallet != null){
            auth()->user()->wallet->withdraw(intval($order->paid_from_wallet));
        }

        // send sms to user
        if (allow_user_order_submitted_sms()){

            // این مربوط به ثبت سفارش پیشفرض خود بانتاشاپ بود که غیر فعال باید باشد
            //SendSmsOrderSubmittedJob::dispatch($user->mobile,$order->order_number);

            if($order->shipping_method === 'post') {
                // ثبت سفارش از طریق پست
                SendSmsOrderSubmittedDenoojPostJob::dispatch($user->mobile,$order->order_number,$user->last_name);

            } elseif($order->shipping_method === 'freightage' && $order->discount === 0) {

                // ثبت سفارش از طریق باربری در حالت غیر جشنواره
                SendSmsOrderSubmittedDenoojFreightageJob::dispatch($user->mobile,$order->order_number,$user->last_name);
            } elseif($order->shipping_method === 'freightage' && $order->discount !== 0) {

                // ثبت سفارش از طریق باربری در حالت جشنواره
                SendSmsOrderSubmittedDenoojFreightageCouponJob::dispatch($user->mobile,$order->order_number,$user->last_name);
            }
            
            // 3 روز پس از ثبت سفارش
            SendSmsOrderSubmittedDenoojThreeDaysJob::dispatch($user->mobile)->delay(now()->addDays(3));
           

            // 15 روز پس از ثبت سفارش
            //SendSmsOrderSubmittedDenooFifteenDaysJob::dispatch($user->mobile,$order->order_number,$user->last_name)->delay(now()->addDays(15));
            SendSmsOrderSubmittedDenooFifteenDaysJob::dispatch($user->mobile,$order->order_number,$user->last_name)->delay(now()->addSeconds(15));
            

            // 40 روز پس از ثبت سفارش
            SendSmsOrderSubmittedDenooFourtyDaysJob::dispatch($user->mobile,$order->order_number,$user->last_name)->delay(now()->addDays(40));
        }

        // notify super admins via email
        $admins = Admin::Role('super-admin')->get();

        if (allow_new_order_email()){
            if ($userPayment != null){
                SendMailJob::dispatch($admins,new NewOrderSubmitted($userPayment));
            }
        }
        if (allow_new_order_sms()){
            foreach ($admins as $admin){
                SendSmsAdminOrderCompletedJob::dispatch($admin->mobile, $order->order_number);
            }
        }
    }
}

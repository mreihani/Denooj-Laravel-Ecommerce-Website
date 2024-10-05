<?php

namespace Modules\ShoppingCart\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Coupons\Entities\Coupon;
use Modules\Settings\Entities\PaymentSetting;
use Modules\Settings\Entities\ShippingSettings;
use Modules\Users\Entities\City;
use Modules\Users\Entities\User;

class HelperController extends Controller
{
    public function calculateTotalShippingCost($address,$cartItems){
        $shippingMethod = 'none';
        $shippingCost = 0;
        $shippingSettings = ShippingSettings::firstOrCreate();
        $freeDeliveryLimit = intval($shippingSettings->free_shipping_limit);
        $totalOrderCost = cart()->getTotal();

        // check if there is a coupon available and valid
        $isCouponValid = cart()->getConditions()->count() ? true : false;

        // check extra weight and products extra shipping costs
        $totalWeight = 0;
        foreach ($cartItems as $cartItem) {

            // جداسازی محصولات غیر برنج
            $categories = $cartItem->associatedModel->categories->pluck('id')->toArray();
            if(in_array(443, $categories)) {
                continue;
            }

            $totalItemWeight = intval($cartItem->associatedModel->weight) * $cartItem->quantity;
            $totalWeight += $totalItemWeight;
        }

        if ($shippingSettings->freightage && $totalWeight >= 40000) {
            $shippingMethod = 'freightage';
            $shippingCost = 0;
        } elseif ($shippingSettings->post && $totalWeight >= 40000) {
            $shippingMethod = 'post';
            $shippingCost = $this->calculatePostPrice($shippingSettings,$totalWeight,$isCouponValid);
        } elseif ($shippingSettings->post) {
            $shippingMethod = 'post';
            $shippingCost = $this->calculatePostPrice($shippingSettings,$totalWeight,$isCouponValid);
        } elseif ($shippingSettings->freightage) {
            $shippingMethod = 'freightage';
            $shippingCost = 0;
        }

        // محاسبه مبلغ کل بدون تخفیف
        $totalDiscount = 0;
        foreach (cart()->getContent() as $item) {
            $rowArr = explode('_',$item->id);
            $inventoryId = null;
            if (count($rowArr) > 1){
                $inventoryId =$rowArr[1];
            }
            $totalDiscount += $item->associatedModel->getDiscountedPrice($inventoryId) * $item->quantity;
        }
        $totalPriceWithoutDiscount = cart()->getSubTotalWithoutConditions() + $totalDiscount;

        // جمع کل تخفیفات
        $totalDiscount = $totalDiscount + cart()->getSubTotalWithoutConditions() - cart()->getSubTotal();

        return [
            'shipping_cost' => $shippingCost,
            'shipping_method' => $shippingMethod,
            'total_weight' => $totalWeight,
            'is_coupon_valid' => $isCouponValid,
            'total_price_without_discount' => $totalPriceWithoutDiscount,
            'total_discount' => $totalDiscount
        ];
    }

    public function calculateTotalShippingCostSelective($address,$cartItems,$selectedShippingMethod){
        $shippingMethod = ($selectedShippingMethod === 'freightage') ? 'freightage' : 'post';
        $shippingCost = 0;
        $shippingSettings = ShippingSettings::firstOrCreate();
        $freeDeliveryLimit = intval($shippingSettings->free_shipping_limit);

        // check if there is a coupon available and valid
        $isCouponValid = cart()->getConditions()->count() ? true : false;

        // check extra weight and products extra shipping costs
        $totalWeight = 0;
        foreach ($cartItems as $cartItem) {

            // جداسازی محصولات غیر برنج
            $categories = $cartItem->associatedModel->categories->pluck('id')->toArray();
            if(in_array(443, $categories)) {
                continue;
            }

            $totalItemWeight = intval($cartItem->associatedModel->weight) * $cartItem->quantity;
            $totalWeight += $totalItemWeight;
        }

        if($shippingMethod === 'post') {
            $shippingCost = $this->calculatePostPrice($shippingSettings,$totalWeight,$isCouponValid);
        } elseif($shippingMethod === 'freightage') {
            $shippingCost = 0;
        }

        // محاسبه مبلغ کل بدون تخفیف
        $totalDiscount = 0;
        foreach (cart()->getContent() as $item) {
            $rowArr = explode('_',$item->id);
            $inventoryId = null;
            if (count($rowArr) > 1){
                $inventoryId =$rowArr[1];
            }
            $totalDiscount += $item->associatedModel->getDiscountedPrice($inventoryId) * $item->quantity;
        }
        $totalPriceWithoutDiscount = cart()->getSubTotalWithoutConditions() + $totalDiscount;

        // جمع کل تخفیفات
        $totalDiscount = $totalDiscount + cart()->getSubTotalWithoutConditions() - cart()->getSubTotal();

        return [
            'shipping_cost' => $shippingCost,
            'shipping_method' => $shippingMethod,
            'total_weight' => $totalWeight,
            'is_coupon_valid' => $isCouponValid,
            'total_price_without_discount' => $totalPriceWithoutDiscount,
            'total_discount' => $totalDiscount
        ];
    }

    private function calculatePostPrice($shippingSettings,$totalWeight,$isCouponValid) {

        if($isCouponValid) {
            $shippingCost = $this->calculatePostPriceCoupon($shippingSettings,$totalWeight,$isCouponValid);
        } else {
            $shippingCost = $this->calculatePostPriceNonCoupon($shippingSettings,$totalWeight,$isCouponValid);
        }

        return $shippingCost;
    }

    private function calculatePostPriceNonCoupon($shippingSettings,$totalWeight,$isCouponValid) {

        if($totalWeight === 0) {
            $shippingCost = 0;
        } elseif($totalWeight >= 20000) {
            $remainderBy20KG = $totalWeight % 20000;
            $shippingCost = (($totalWeight - $remainderBy20KG) / 20000) * intval($shippingSettings->post_cost_twenty);

            if($remainderBy20KG >= 15000) {
                $shippingCost += intval($shippingSettings->post_cost_ten) + intval($shippingSettings->post_cost_five);
            } elseif($remainderBy20KG < 15000 && $remainderBy20KG >= 10000) {
                $shippingCost += intval($shippingSettings->post_cost_ten);
            } elseif($remainderBy20KG < 10000 && $remainderBy20KG >= 5000) {
                $shippingCost += intval($shippingSettings->post_cost_five);
            }
        } elseif($totalWeight >= 10000) {
            $remainderBy10KG = $totalWeight % 10000;
            $shippingCost = (($totalWeight - $remainderBy10KG) / 10000) * intval($shippingSettings->post_cost_ten);

            if($remainderBy10KG !== 0) {
                $shippingCost += intval($shippingSettings->post_cost_five);
            } 
        } else {
            $shippingCost = intval($shippingSettings->post_cost_five);
        }

        return $shippingCost;
    }

    private function calculatePostPriceCoupon($shippingSettings,$totalWeight,$isCouponValid) {

        if($totalWeight === 0) {
            $shippingCost = 0;
        } elseif($totalWeight >= 20000) {
            $remainderBy20KG = $totalWeight % 20000;
            $shippingCost = (($totalWeight - $remainderBy20KG) / 20000) * intval($shippingSettings->post_cost_off_twenty);

            if($remainderBy20KG >= 15000) {
                $shippingCost += intval($shippingSettings->post_cost_off_ten) + intval($shippingSettings->post_cost_off_five);
            } elseif($remainderBy20KG < 15000 && $remainderBy20KG >= 10000) {
                $shippingCost += intval($shippingSettings->post_cost_off_ten);
            } elseif($remainderBy20KG < 10000 && $remainderBy20KG >= 5000) {
                $shippingCost += intval($shippingSettings->post_cost_off_five);
            }
        } elseif($totalWeight >= 10000) {
            $remainderBy10KG = $totalWeight % 10000;
            $shippingCost = (($totalWeight - $remainderBy10KG) / 10000) * intval($shippingSettings->post_cost_off_ten);

            if($remainderBy10KG !== 0) {
                $shippingCost += intval($shippingSettings->post_cost_off_five);
            } 
        } else {
            $shippingCost = intval($shippingSettings->post_cost_off_five);
        }

        return $shippingCost;
    }

    public function calculateExtraWeightPrice($shippingSettings, $shippingMethod, $totalItemsWeight)
    {

        if ($shippingMethod == 'post_pishtaz') {
            $kilo = floor($totalItemsWeight / 1000) * $shippingSettings->cost_post_pishtaz_kilogram;
            $grams = (($totalItemsWeight % 1000) / 1000) * $shippingSettings->cost_post_pishtaz_kilogram;
            return $kilo + $grams;
        } else if ($shippingMethod == 'bike') {
            $bikeKilo = floor($totalItemsWeight / 1000) * $shippingSettings->cost_bike_kilogram;
            $bikeGrams = (($totalItemsWeight % 1000) / 1000) * $shippingSettings->cost_bike_kilogram;
            return $bikeKilo + $bikeGrams;
        }
        return 9999999;
    }

    function arraySearch($array, $key, $value): array{
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->arraySearch($subarray, $key, $value));
            }
        }

        return $results;
    }

    public function checkCartConditions($userId = null){
        if ($userId == null) {
            $userId = auth()->id();
        }
        $user = User::find($userId);

        foreach (cart()->getConditions() as $condition) {
            $coupon = Coupon::find($condition->getAttributes()['coupon_id']);
            if ($coupon) {
                if ($coupon->min_price > cart()->getSubTotalWithoutConditions()) {
                    cart()->removeCartCondition($condition->getName());
                    $user->coupons()->detach($coupon->id);
                }
            }else{
                cart()->removeCartCondition($condition->getName());
            }
        }
    }

    public function checkGateways($driverName): array{
        
        $callbackUrl = null;
        $config = [];
        $result = [
            'callback' => $callbackUrl,
            'config' => $config,
            'success' => false,
            'msg' => ''
        ];

        // get payment settings
        $settings = PaymentSetting::firstOrCreate();
        $sandbox = $settings->sandbox;
        $paymentDescription = $settings->payment_description;

        if ($driverName == 'zarinpal'){
            $callbackUrl = env('APP_URL') . env('ZARINPAL_CALLBACK_URL_ORDER');

            // check zarinpal settings
            if(empty($settings->zarinpal_merchant_id)){
                $result['msg'] = "درگاه پرداخت زرین پال فعال نیست! درصورت وجود مشکل با مدیر سایت تماس بگیرید!";
                return $result;
            }
            $config = [
                'mode' => $sandbox ? 'sandbox' : 'normal',
                'merchantId' => $settings->zarinpal_merchant_id,
                'callbackUrl' => $callbackUrl,
                'description' => $paymentDescription,
            ];

        }elseif ($driverName == 'zibal'){
            $callbackUrl = env('APP_URL') .  env('ZIBAL_CALLBACK_URL_ORDER');

            // check zibal settings
            if(empty($settings->zibal_merchant_id)){
                $result['msg'] = 'درگاه پرداخت زیبال فعال نیست! درصورت وجود مشکل با مدیر سایت تماس بگیرید!';
                return $result;
            }
            $config = [
                'merchantId' => $settings->zibal_merchant_id,
                'callbackUrl' => $callbackUrl,
                'description' => $paymentDescription,
                'sandbox' => $sandbox,
            ];

        }elseif ($driverName == 'nextpay'){
            $callbackUrl = env('APP_URL') .  env('NEXTPAY_CALLBACK_URL_ORDER');

            // check nextpay settings
            if(empty($settings->nextpay_merchant_id)){
                $result['msg'] = 'درگاه پرداخت نکست پی فعال نیست! درصورت وجود مشکل با مدیر سایت تماس بگیرید!';
                return $result;
            }
            $config = [
                'merchantId' => $settings->nextpay_merchant_id,
                'callbackUrl' => $callbackUrl,
                'description' => $paymentDescription,
                'sandbox' => $sandbox,
            ];

        }elseif ($driverName == 'pasargad'){
            $callbackUrl = env('APP_URL') .  env('PASARGAD_CALLBACK_URL_ORDER');

            // check nextpay settings
            if(empty($settings->pasargad_merchant_id)){
                $result['msg'] = 'درگاه پرداخت پاسارگاد فعال نیست! درصورت وجود مشکل با مدیر سایت تماس بگیرید!';
                return $result;
            }
            $config = [
                'merchantId' => $settings->pasargad_merchant_id,
                'terminalCode' => $settings->pasargad_terminal,
                'callbackUrl' => $callbackUrl,
                'description' => $paymentDescription,
//                'sandbox' => $sandbox,
            ];

        }  elseif ($driverName == 'idpay'){
            $callbackUrl = env('APP_URL') .  env('IDPAY_CALLBACK_URL_ORDER');

            // check idpay settings
            if(empty($settings->idpay_merchant_id)){
                $result['msg'] = 'درگاه پرداخت آی‌دی‌پی فعال نیست! درصورت وجود مشکل با مدیر سایت تماس بگیرید!';
                return $result;
            }
            $config = [
                'merchantId' => $settings->idpay_merchant_id,
                'callbackUrl' => $callbackUrl,
                'description' => $paymentDescription,
                'sandbox' => $sandbox,
            ];

        }elseif ($driverName == 'parsian'){
            $callbackUrl = env('APP_URL') .  env('PARSIAN_CALLBACK_URL_ORDER');

            // check parsian settings
            if(empty($settings->parsian_pin_code)){
                $result['msg'] = 'درگاه پرداخت پارسیان فعال نیست! درصورت وجود مشکل با مدیر سایت تماس بگیرید!';
                return $result;
            }
            $config = [
                'merchantId' => $settings->parsian_pin_code,
                'callbackUrl' => $callbackUrl,
                'description' => $paymentDescription,
//                'sandbox' => $sandbox,
            ];

        }elseif ($driverName == 'mellat' || $driverName == 'behpardakht'){
            $driverName = 'behpardakht';
            $callbackUrl = env('APP_URL') .  env('MELLAT_CALLBACK_URL_ORDER');

            // check mellat settings
            if(empty($settings->mellat_payane) || empty($settings->mellat_username) || empty($settings->mellat_password)){
                $result['msg'] = 'درگاه پرداخت ملت فعال نیست! درصورت وجود مشکل با مدیر سایت تماس بگیرید!';
                return $result;
            }
            $config = [
                'terminalId' => $settings->mellat_payane,
                'username' => $settings->mellat_username,
                'password' => $settings->mellat_password,
                'callbackUrl' => $callbackUrl,
                'description' => $paymentDescription,
//                'sandbox' => $sandbox,
            ];

        }else{
            $result['msg'] = 'درگاه پرداخت انتخابی معتبر نیست!';
            return $result;
        }



        $result['callback'] = $callbackUrl;
        $result['config'] = $config;
        $result['success'] = true;
        return $result;
    }
}

<?php

namespace Modules\Coupons\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Coupons\Entities\Coupon;

class CouponController extends Controller
{
    public function applyCoupon(Request $request)
    {
        if ($request->ajax()) {

            // check coupon exist
            $coupon = Coupon::where('code', $request->code)->first();
            if (!$coupon) {
                $msg = 'کد تخفیف وارد شده صحیح نیست.';
                return response(['status' => 'error', 'msg' => $msg]);
            }

            // check for expire
            if ($coupon->isExpired()) {
                $msg = 'این کد تخفیف منقضی شده است.';
                return response(['status' => 'error', 'msg' => $msg]);
            }

            // check max usage
            if (($coupon->users->count() >= $coupon->max_usage) && !$coupon->infinite) {
                $msg = 'اعتبار این کد تخفیف تمام شده است';
                return response(['status' => 'error', 'msg' => $msg]);
            }

            // check for already used
            $exist = $coupon->users->contains(auth()->id());
            if ($exist && !$coupon->infinite) {
                $msg = 'شما قبلا از این کد تخفیف استفاده کرده اید.';
                return response(['status' => 'error', 'msg' => $msg]);
            }

            // check for min price
            $minPrice = $coupon->min_price;
            $totalItemPrice = cart()->getSubTotalWithoutConditions();
            if ($minPrice > $totalItemPrice) {
                $msg = 'حداقل مبلغ خرید باید ' . number_format($minPrice) . ' تومان باشد.';
                return response(['status' => 'error', 'msg' => $msg]);
            }


            // add condition to cart
            $discountPrice = floor((intval($coupon->percent) / 100) * $totalItemPrice);
            if ($coupon->type == 'amount') {
                $discountPrice = $coupon->amount;
            }
            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => $coupon->code,
                'type' => 'promo',
                'value' => '-' . $discountPrice,
                'target' => 'subtotal',
                'attributes' => array(
                    'coupon_id' => $coupon->id
                )
            ));
            cart()->condition($condition);

            // attach coupon to user
            auth()->user()->coupons()->attach($coupon->id);

            $msg = 'کد تخفیف با موفقیت روی سفارش شما اعمال شد.';
            return response(['status' => 'success', 'msg' => $msg]);
        }
        return response(['status' => 'error', 'msg' => "unauthorized"]);
    }

    public function removeCoupon(Request $request)
    {

        if ($request->ajax()) {
            // check coupon exist
            $coupon = Coupon::where('code', $request->code)->first();
            if (!$coupon) {
                $msg = 'کد تخفیف موجود نیست.';
                return response(['status' => 'error', 'msg' => $msg]);
            }

            // remove condition from cart
            cart()->removeCartCondition($request->condition_name);

            // detach user and coupon
            auth()->user()->coupons()->detach($coupon->id);

            $msg = 'کد تخفیف حذف شد.';
            return response(['status' => 'success', 'msg' => $msg]);
        }

        return response(['status' => 'success', 'msg' => 'unauthorized']);
    }
}

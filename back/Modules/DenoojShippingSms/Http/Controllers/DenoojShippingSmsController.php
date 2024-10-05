<?php

namespace Modules\DenoojShippingSms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\SmsSetting;
use Illuminate\Contracts\Support\Renderable;

class DenoojShippingSmsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:edit-setting-sms'])->only(['sms', 'smsUpdate']);
    }

    public function sms()
    {
        $settings = SmsSetting::first();
        
        return view('denoojshippingsms::sms',compact('settings'));
    }

    public function smsUpdate(Request $request, SmsSetting $settings)
    {
        $settings->update([
            'denooj_post' => $request->denooj_post,
            'denooj_ordinary_freightage' => $request->denooj_ordinary_freightage,
            'denooj_coupon_freightage' => $request->denooj_coupon_freightage,
            'denooj_three_days' => $request->denooj_three_days,
            'denooj_fifteen_days' => $request->denooj_fifteen_days,
            'denooj_fifteen_days_link' => $request->denooj_fifteen_days_link,
            'denooj_fourty_days' => $request->denooj_fourty_days,
            'denooj_fourty_days_link' => $request->denooj_fourty_days_link,
        ]);
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');

        return redirect()->back();
    }
}

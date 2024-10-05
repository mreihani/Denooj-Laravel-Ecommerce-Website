<?php

namespace Modules\DenoojShipping\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Settings\Entities\ShippingSettings;

class DenoojShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:edit-setting-shipping'])->only(['shipping', 'shippingUpdate']);
    }

    public function shipping()
    {
        $settings = ShippingSettings::first();
        
        return view('denoojshipping::shipping',compact('settings'));
    }

    public function shippingUpdate(Request $request, ShippingSettings $settings)
    {
        $request->validate([
            'freightage_title' => $request->freightage === 'on' ? 'required' : '',
            'freightage_logo' =>  $request->freightage === 'on' ? 'required' : '',
            'post_title' => $request->post === 'on' ? 'required' : '',
            'post_logo' => $request->post === 'on' ? 'required' : '',
            'post_cost_five' => $request->post === 'on' ? 'required' : '',
            'post_cost_ten' => $request->post === 'on' ? 'required' : '',
            'post_cost_twenty' => $request->post === 'on' ? 'required' : '',
            'post_cost_off_five' => $request->post === 'on' ? 'required' : '',
            'post_cost_off_ten' => $request->post === 'on' ? 'required' : '',
            'post_cost_off_twenty' => $request->post === 'on' ? 'required' : '',
        ],[
            'freightage_title.required' => 'لطفا عنوان باربری را وارد نمایید.',
            'freightage_logo.required' => 'لطفا آدرس تصویر باربری را وارد نمایید.',
            'post_title.required' => 'لطفا عنوان روش پست را وارد نمایید.',
            'post_logo.required' => 'لطفا آدرس تصویر پست را وارد نمایید.',
            'post_cost_five.required' => 'لطفا هزینه ارسال 5 کیلوگرم کالا از طریق پست در حالت عادی را وارد نمایید.',
            'post_cost_ten.required' => 'لطفا هزینه ارسال 10 کیلوگرم کالا از طریق پست در حالت عادی را وارد نمایید.',
            'post_cost_twenty.required' => 'لطفا هزینه ارسال 20 کیلوگرم کالا از طریق پست در حالت عادی را وارد نمایید.',
            'post_cost_off_five.required' => 'لطفا هزینه ارسال 5 کیلوگرم کالا از طریق پست در زمان جشنواره را وارد نمایید.',
            'post_cost_off_ten.required' => 'لطفا هزینه ارسال 10 کیلوگرم کالا از طریق پست در زمان جشنواره را وارد نمایید.',
            'post_cost_off_twenty.required' => 'لطفا هزینه ارسال 20 کیلوگرم کالا از طریق پست در زمان جشنواره را وارد نمایید.',
        ]);

        $settings->update([
            'freightage' => $request->freightage === 'on' ? 1 : 0,
            'post' => $request->post === 'on' ? 1 : 0,
            'freightage_title' => $request->freightage_title,
            'freightage_logo' => $request->freightage_logo,
            'post_title' => $request->post_title,
            'post_logo' => $request->post_logo,
            'post_cost_five' => $request->post_cost_five,
            'post_cost_ten' => $request->post_cost_ten,
            'post_cost_twenty' => $request->post_cost_twenty,
            'post_cost_off_five' => $request->post_cost_off_five,
            'post_cost_off_ten' => $request->post_cost_off_ten,
            'post_cost_off_twenty' => $request->post_cost_off_twenty,
        ]);
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');

        return redirect()->back();
    }
}

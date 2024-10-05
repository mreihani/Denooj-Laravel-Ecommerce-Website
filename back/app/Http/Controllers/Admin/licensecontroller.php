<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Settings\Entities\GeneralSetting;

class licensecontroller extends Controller
{
    public function showLicenseForm(){
        $settings = GeneralSetting::first();
        return view('admin.views.auth.license',compact('settings'));
    }

    public function checkLicense(Request $request){
        $request->validate([
            'username' => 'required',
            'order_id' => 'required'
        ]);

        require_once 'submitlicense.php';
        $result = submit_license($request['username'],$request['order_id']);
        $settings = GeneralSetting::first();
        if ($result){
            $settings->update([
                'username' => $request->username,
                'order_id' => $request->order_id,
                'verified' => true
            ]);
            session()->flash('success','لایسنس با موفقیت فعال شد.');
            return redirect()->route('admin.dashboard');
        }else{
            $settings->update([
                'verified' => false
            ]);
        }
        session()->flash('error','اطلاعات وارد شده صحیح نیست.');
        return redirect()->back();
    }

}

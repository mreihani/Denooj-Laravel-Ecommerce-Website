<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Admins\Entities\Admin;

class ProfileController extends Controller
{
    public function index(){
        $admin = auth()->guard('admin')->user();
        return view('admin.views.profile.index',compact('admin'));
    }

    public function security(){
        $admin = auth()->guard('admin')->user();
        return view('admin.views.profile.security',compact('admin'));
    }

    public function update(Admin $admin,Request $request){
        request()->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|digits:11',
            'avatar' => 'nullable|mimes:jpeg,jpg,png,gif',
            'email' => 'required|email|max:255|unique:admins,email,'.$admin->id,
            'instagram' => 'nullable|string|max:1024',
            'telegram' => 'nullable|string|max:1024',
            'facebook' => 'nullable|string|max:1024',
            'twitter' => 'nullable|string|max:1024',
            'linkedin' => 'nullable|string|max:1024',
            'dribbble' => 'nullable|string|max:1024',
        ]);
        $inputs = request()->except('_token');

        // avatar image
        if ($request->remove_avatar_image != null) {
            $fileUrl = request('remove_avatar_image');
            $this->removeStorageFile($fileUrl);
            $inputs['avatar'] = null;
        }
        if ($request->hasFile('avatar')) {
            $imageFile = $request->file('avatar');
            $inputs['avatar'] = $this->uploadRealFile($imageFile,'admins');
        }

        $admin->update($inputs);
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect()->back();
    }

    public function resetPassword(Admin $admin,Request $request){
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);
        $current = $request->current_password;
        $password = $request->password;

        if (Hash::check($current,$admin->password)){
            $admin->update(['password' => Hash::make($password)]);
            session()->flash('success','کلمه عبور با موفقیت تغییر کرد.');
        }else{
            session()->flash('error','کلمه عبور فعلی شما صحیح نمیباشد.');
        }
        return redirect()->back();

    }
}

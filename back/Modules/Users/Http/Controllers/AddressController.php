<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Users\Entities\Address;
use Modules\Users\Entities\City;

class AddressController extends Controller
{

    public function getCities(Request $request){
        $provinceId = $request->province_id;
        return City::where('province',$provinceId)->get();
    }

    public function store(Request $request){
        $request->validate([
            'first_name' => $request->first_name ? 'required' : '',
            'last_name' => $request->last_name ? 'required' : '',
            'province' => 'required',
            'city' => 'required',
            'post_code' => 'required|digits:10',
            'phone' => 'required|digits:11',
            'address' => 'required|max:255',
            'full_name' => 'required|string|max:255',
        ]);
        $inputs = $request->except('_token');

        auth()->user()->addresses()->create($inputs);

        // update first_name and last_name if not found in user
        if(empty(auth()->user()->first_name) || empty(auth()->user()->last_name)) {
            auth()->user()->update([
                'first_name' => $inputs['first_name'],
                'last_name' => $inputs['last_name'],
            ]);
        }

        session()->flash('success','آدرس جدید با موفقیت ذخیره شد.');
        return redirect()->back();
    }

    public function delete($id){
        $address = Address::find($id);
        if (!$address){
            return redirect(back());
        }
        session()->flash('success','آدرس با موفقیت حذف شد.');
        $address->delete();
        return redirect(route('panel.addresses'));
    }

    public function edit($id){
        $address = Address::find($id);
        if (!$address || $address->user_id != auth()->id()){
            return redirect(404);
        }
        return view('users::addresses.edit',compact('address'));
    }

    public function update(Request $request,Address $address){
        $request->validate([
            'province' => 'required',
            'city' => 'required',
            'post_code' => 'required|digits:10',
            'phone' => 'required|digits:11',
            'address' => 'required|max:255',
            'full_name' => 'required|string|max:255',
        ]);

        $inputs = $request->except('_token');
        if ($address->user_id != auth()->id()){
            return redirect(404);
        }
        $address->update($inputs);
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect(route('panel.addresses'));
    }

}

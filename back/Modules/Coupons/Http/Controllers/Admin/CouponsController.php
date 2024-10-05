<?php

namespace Modules\Coupons\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Coupons\Entities\Coupon;

class CouponsController extends Controller
{
    public function index(){
        $coupons = Coupon::latest()->paginate(20);
        return view('coupons::admin.index',compact('coupons'));
    }

    public function create(){
        return view('coupons::admin.create');
    }

    public function store(Request $request){
        
        $request->validate([
            'code' => 'required|string|max:255',
            'expire_after_day' => 'required',
            'type' => 'required',
            'amount' => 'nullable|integer|required_if:type,amount|min:1000',
            'percent' => 'nullable|integer|required_if:type,percent|min:1|max:80',
            'min_price' => 'required|integer',
            'max_usage' => 'required|integer|min:1'
        ]);
        $inputs = $request->all();
        $code = $request->code;

        // check code validation
        if (preg_match('/[^A-Za-z0-9.\w]/', $code)) {
            session()->flash('error','فیلد کد تخفیف فقط باید شامل حروف لاتین (انگلیسی) ، نقطه(.) و زیرخط(_) باشد.');
            return redirect()->back()->withInput();
        }

        // check code already exist
        $exist = Coupon::where('code',$request->code)->first();
        if ($exist) {
            session()->flash('error','کد تخفیف انتخاب شده در دسترس نیست، لطفا یک کد دیگر وارد کنید.');
            return redirect()->back()->withInput();
        }

        $inputs['code'] = $code;

        // calculate expire date
        $expire_at = Carbon::now()->addDays($request->expire_after_day);
        $inputs['expire_at'] = $expire_at;
        $inputs['infinite'] = $request->infinite == 'on' ? 1 : 0;
        
        Coupon::create($inputs);
        session()->flash('success','کد تخفیف جدید با موفقیت اضافه شد.');
        return redirect(route('coupons.index'));
    }

    public function edit(Coupon $coupon){
        return view('coupons::admin.edit',compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'nullable|integer|required_if:type,amount,min:1000',
            'percent' => 'nullable|integer|required_if:type,percent,min:1,max:80',
            'min_price' => 'required|integer',
            'max_usage' => 'required|integer|min:1',
        ]);
        $inputs = $request->all();
        $inputs['infinite'] = $request->infinite == 'on' ? 1 : 0;
        $coupon->update($inputs);

        session()->flash('success','کد تخفیف با موفقیت ویرایش شد.');
        return redirect(route('coupons.index'));
    }

    public function destroy(Coupon $coupon){
        $coupon->delete();
        session()->flash('success','کد تخفیف با موفقیت حذف شد');
        return redirect(route('coupons.index'));
    }

    public function search()
    {
        $query = request('query');
        $coupons = Coupon::where('code', 'LIKE', '%' . $query . '%')
            ->paginate(20);
        return view('coupons::admin.index', compact('coupons', 'query'));
    }
}

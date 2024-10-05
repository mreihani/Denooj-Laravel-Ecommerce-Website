<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Custom\SmsApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\Products\Entities\Product;
use Modules\Users\Entities\MobileNumber;
use Modules\Users\Entities\User;

class AuthController extends Controller
{
    public function signin()
    {
        if(!session()->has('url.intended')){
            session()->put('url.intended', url()->previous());
        }

        $type = '';
        if (\request()->has('type') && request('type') == 'forget'){
           $type = 'forget';
        }

        session()->flash('type',$type);
        return view('users::auth.signin');
    }

    public function doSignin(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:11',
        ]);

        $type = '';
        if ($request->has('type')){
            $type = $request->type;
        }

        $mobile = $request->mobile;
        $code = $this->generateCode();
//        $code = '12345';

        // create or update token
        $mobileToken = MobileNumber::where('number', $mobile)->first();
        if ($mobileToken) {
            $mobileToken->update(['auth_code' => $code]);
        } else {
            MobileNumber::create([
                'number' => $mobile,
                'auth_code' => $code
            ]);
        }

        $rememberMe = ($request->remember_me === 'on') ? true : false;

        Session::flash('mobile', $mobile);
        Session::flash('remember_me', $rememberMe);
        Session::flash('type', $type);

        // fix denooj.com remember me issue
        session()->put('denooj_remember_me', $rememberMe);

        SmsApi::sendAuthCode($mobile,$code);
        return redirect(route('verify'));
    }

    public function resendAuthCode(){
        if (request()->ajax() && request()->has('mobile')){
            $mobile = request('mobile');
            $number = MobileNumber::where('number',$mobile)->first();
            if ($number){

                // check time limit
                $latestUpdate = Carbon::create($number->updated_at);
                $seconds = Carbon::now()->diffInSeconds($latestUpdate);
                $secondsLeft = 45 - $seconds;
                if ($seconds >= 45){
                    // resend code
                    $code = $this->generateCode();
                    SmsApi::sendAuthCode($number->number,$code);
                    $number->update(['auth_code' => $code]);

                    return response([
                        'status' => 'success',
                        'msg' => "کد یکبارمصرف مجددا به شماره $mobile ارسال شد."
                    ]);
                }else{
                    return response([
                        'status' => 'warning',
                        'msg' => "لطفا $secondsLeft ثانیه صبر کنید."
                    ]);
                }
            }
            return response(['status' => 'error']);
        }
        return response(['status' => 'error']);
    }

    public function verify()
    {
        if (Session::has('mobile')) {
            return view('users::auth.verify');
        } else {
            return redirect(route('signin'));
        }
    }

    public function doVerify(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'auth_code' => 'required'
        ]);

        $mobileToken = MobileNumber::where('number', $request->mobile)->first();
        $type = $request->type;

        // check user exists
        if (!$mobileToken) {
            return redirect(route('signin'));
        }

        // check auth code
        if ($mobileToken->auth_code === $request->auth_code) {

            $user = User::where('mobile', $request->mobile)->first();
            $rememberMe = false;

            // create user if not exist
            if (!$user) {
                $apiToken = Str::random(90);
                $user = User::create(['mobile' => $request->mobile, 'api_token' => $apiToken]);
                $rememberMe = true;
            }

            if (!$rememberMe) {
                $rememberMe = (!empty($request->remember_me)) ? TRUE : FALSE;
            }

            // set token to user
            $mobileToken->update(['user_id' => $user->id]);


            $this->afterValidSignin($user,$rememberMe);

            // check type
            if ($type == 'forget'){
                $user->update(['password' => null]);
            }

            // check for password set
            if ($user->password == null){
                session()->flash('permission',$request->auth_code);
                return redirect(route('set_password'));
            }

            return redirect()->intended();
        } else {
            // wrong auth code
            session()->flash('mobile',$request->mobile);
            session()->flash('auth_code', 'کد یکبار مصرف را اشتباه وارد کرده اید');
            return redirect()->back();
        }
    }

    public function loginWithPassword()
    {
        return view('users::auth.signin_password');
    }

    public function doLoginWithPassword(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'password' => 'required',
        ]);

        $mobile = $request->mobile;

        $user = User::where('mobile', $mobile)->first();

        // check user exist
        if (!$user) {
            Session::flash('error', "کاربری با این شماره موبایل پیدا نشد.");
            return redirect(route('login.with_password'));
        }

        $rememberMe = (!empty($request->remember_me)) ? TRUE : FALSE;

        if (Hash::check($request->password, $user->password)) {
            $this->afterValidSignin($user,$rememberMe);
        }
        Session::flash('error', "کلمه عبور یا شماره موبایل اشتباه است.");
        return redirect(route('login.with_password'))->withInput();
    }

    public function loginWithEmail()
    {
        return view('users::auth.signin_email');
    }

    public function doLoginWithEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;

        $user = User::where('email', $email)->first();

        // check user exist
        if (!$user) {
            Session::flash('error', "کاربری با این ایمیل پیدا نشد.");
            return redirect(route('login.with_email'));
        }

        $rememberMe = (!empty($request->remember_me)) ? TRUE : FALSE;

        if (Hash::check($request->password, $user->password)) {
            $this->afterValidSignin($user,$rememberMe);
        }

        Session::flash('error', "کلمه عبور یا ایمیل اشتباه است.");
        return redirect(route('login.with_email'))->withInput();
    }

    public function afterValidSignin($user, $rememberMe){
        // logout admin guard
        auth()->guard('admin')->logout();

        // fix remember me issue for SMS login for Denooj.com
        if(session()->has('denooj_remember_me')) {
            $rememberMe = session()->get('denooj_remember_me');
        }

        // login
        auth()->login($user, $rememberMe);
       
        // merge guest shopping cart
        if (get_guest_cart()){
            $guestCartItems = get_guest_cart()->getContent();
            foreach ($guestCartItems as $item) {
                // check item stock
                $product = Product::find($item->associatedModel->id);
                if ($product && $product->inStock() && $product->getStockQuantity($item->id) >= $item->quantity){
                    cart()->remove($item->id);
                    cart()->add(array(
                        'id' => $item->id,
                        'name' => $item->name,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'attributes' => $item->attributes,
                        'associatedModel' => $item->associatedModel
                    ));
                }else{
                    cart()->remove($item->id);
                }
            }

            // clear guest cart
            get_guest_cart()->clear();
        }

        return redirect()->back();
    }

    public function setPassword(){
        $mobileToken = MobileNumber::where('number',auth()->user()->mobile)->first();
        if (session()->has('permission') & session('permission') == $mobileToken->auth_code){
            return view('users::auth.set_password');
        }
        return redirect(route('home'));
    }

    public function resetPassword(Request $request){
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->intended();
    }

    public function logout()
    {
        auth()->logout();
        return redirect(route('home'));
    }

    public function generateCode($codeLength = 5)
    {
        $max = pow(10, $codeLength);
        $min = $max / 10 - 1;
        $code = mt_rand($min, $max);
        return $code;
    }
}

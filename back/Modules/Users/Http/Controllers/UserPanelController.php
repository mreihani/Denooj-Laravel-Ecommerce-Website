<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Custom\SmsApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Modules\Blog\Entities\Post;
use Modules\Products\Entities\Product;
use Modules\Users\Entities\MobileNumber;

class UserPanelController extends Controller
{
    public function overview(){
        $user = auth()->user();
        $ticketsCount = $user->tickets()->count();

        // total ordered products
        $ordersProductCount = 0;
        foreach ($user->orders as $order) {
            $ordersProductCount += $order->getTotalQuantity();
        }

        $cartCount = \Cart::session(auth()->id())->getContent()->count();

        $orders = auth()->user()->orders()->limit(4)->get();


        return view('users::.overview',compact('user','ordersProductCount','ticketsCount','cartCount','orders'));
    }

    public function edit(){
        $user = auth()->user();
        return view('users::.edit',compact('user'));
    }

    public function updateUser(Request $request){
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'national_code' => 'required|digits:10',
            'email' => 'nullable|email|max:255',
        ]);

        $inputs = $request->except('_token');

        if ($request->avatar){
            if ($request->avatar == 'default'){
                $inputs['avatar'] = null;
            }else if (strlen($request->avatar) < 20){
                $inputs['avatar'] = null;
            }else{
                $inputs['avatar'] = json_decode($request->avatar);
            }
        }

        auth()->user()->update($inputs);

//        if ($request->has('checkout')) {
//            return redirect(route('checkout'));
//        }
        return redirect(route('panel.edit'));
    }

    public function resetPassword(){
        $user = auth()->user();
        return view('users::.reset_password',compact('user'));
    }

    public function updatePassword(Request $request){
        $request->validate([
            'password' => 'required|confirmed|min:8|max:255',
            'password_confirmation' => 'required'
        ]);
        $code = $this->generateCode();
//        $code = "12345";
        $token = MobileNumber::where('number', '=', auth()->user()->mobile)->first();
        $token->update(['auth_code' => $code]);
        SmsApi::sendAuthCode(auth()->user()->mobile,$code);
        session()->flash('password',$request->password);
        return redirect(route('panel.verify_password'));
    }

    public function verifyPassword(){
        $user = auth()->user();
        if (session()->has('password')) {
            return view('users::.verify_password',compact('user'));
        }else {
            return view('users::.reset_password',compact('user'));
        }
    }

    public function doVerifyPassword(Request $request){
        $request->validate([
            'password' => 'required|min:8|max:255',
            'code' => 'required'
        ]);

        $user = auth()->user();
        $token = MobileNumber::where('number', '=', auth()->user()->mobile)->first();
        // check exists
        if (!$token) {
            return redirect(route('register'));
        }

        // check auth code
        if ($token->auth_code === $request->code) {

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            Session::flash('success', 'کلمه عبور شما با موفقیت تغییر کرد.');
            return redirect(route('panel.edit'));
        } else {

            // wrong auth code
            session()->flash('password',$request->password);
            session()->flash('error','کد یکبار مصرف را اشتباه وارد کرده اید');
            return redirect(route('panel.verify_password',compact('user')));
        }

    }

    public function addresses(){
        $addresses = auth()->user()->addresses;
        return view('users::.addresses.index',compact('addresses'));
    }

    public function generateCode($codeLength = 5)
    {
        $max = pow(10, $codeLength);
        $min = $max / 10 - 1;
        $code = mt_rand($min, $max);
        return $code;
    }

    public function favorites(){
        $products = Product::whereLikedBy(auth()->id())->paginate(20);
        return view('users::.favorites',compact('products'));
    }

    public function toggleFavorite(){
        $id = request('id');
        $product = Product::find($id);
        if ($product){
            if ($product->liked()){
                $product->unlike();
                $result = "unlike";
            }else{
                $product->like();
                $result = "like";
            }
            return response([
                'status' => 'success',
                'bookmark' => $result
            ]);
        }else{
            return response([
                'status' => 'error',
            ]);
        }
    }

    public function removeFavorite(){
        $id = request('id');
        $product = Product::find($id);
        if ($product){
            $product->unlike();
            return response([
                'status' => 'success',
            ]);
        }else{
            return response([
                'status' => 'error',
            ]);
        }
    }

    public function favoritesPost(){
        $posts = Post::whereLikedBy(auth()->id())->paginate(20);
        return view('users::.favorites_post',compact('posts'));
    }

    public function toggleFavoritePost(){
        $id = request('id');
        $post = Post::find($id);
        if ($post){
            if ($post->liked()){
                $post->unlike();
                $result = "unlike";
            }else{
                $post->like();
                $result = "like";
            }
            return response([
                'status' => 'success',
                'bookmark' => $result
            ]);
        }else{
            return response([
                'status' => 'error',
            ]);
        }
    }

}

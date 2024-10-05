<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Coupons\Http\Controllers\CouponController;
use Modules\ShoppingCart\Http\Controllers\CartController;
use Modules\ShoppingCart\Http\Controllers\ShoppingController;


Route::prefix('cart')->group(function (){

    // cart functions
    Route::post('add', [CartController::class,'add']);
    Route::post('increase', [CartController::class,'increase']);
    Route::post('decrease', [CartController::class,'decrease']);
    Route::post('delete', [CartController::class,'delete']);

    // coupons
    Route::post('coupon/apply/',[CouponController::class,'applyCoupon']);
    Route::post('coupon/remove/',[CouponController::class,'removeCoupon']);

    // shopping steps
    Route::get('/',[CartController::class,'index'])->name('cart');
    Route::middleware('auth')->group(function () {
        Route::post('calc-shipping-cost', [ShoppingController::class,'calcShippingCost']);
        Route::post('reload', [ShoppingController::class,'reload'])->name('cart.reload');
        Route::get('checkout', [ShoppingController::class,'checkout'])->name('cart.checkout');
//        Route::post('pay', [ShoppingController::class,'payOrder'])->name('cart.pay');
//        Route::post('repay/{order}', [ShoppingController::class,'repay'])->name('cart.repay');
    });
});



//Route::prefix('cart')->group(function (){
//    Route::get('/','CartController@index')->name('cart');
//    Route::post('add', 'CartController@add');
//    Route::post('increase', 'CartController@increase');
//    Route::post('decrease', 'CartController@decrease');
//    Route::post('delete', 'CartController@deleteItem');
//});
//
//
//// shopping steps routes
//Route::prefix('panel')->middleware(['auth','active'])->group(function () {
//    Route::prefix('cart')->middleware('cart')->group(function (){
//        Route::get('address','ShoppingController@address')->name('cart.address');
//        Route::post('set-address', 'ShoppingController@setAddress')->name('cart.address.set');
//        Route::get('shipping','ShoppingController@shipping')->name('cart.shipping');
//        Route::post('get-shipping-cost', 'ShoppingController@getShippingCost');
//        Route::post('set-shipping', 'ShoppingController@setShipping')->name('cart.shipping.set');
//        Route::get('checkout', 'ShoppingController@checkout')->name('cart.checkout');
//    });
//});
//Route::post('reload', 'ShoppingController@reload')->name('cart.reload');


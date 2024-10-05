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

// admin
Route::prefix('admin')->middleware(['role_or_permission:super-admin|manage-coupons','auth:admin'])->group(function (){
    Route::post('coupons/search','Admin\CouponsController@search')->name('coupons.search');
    Route::resource('coupons', 'Admin\CouponsController');
});


// coupons
Route::prefix('panel')->middleware(['auth','active'])->group(function () {
    Route::post('coupon/apply','CouponController@applyCoupon');
    Route::post('coupon/remove','CouponController@removeCoupon');
});

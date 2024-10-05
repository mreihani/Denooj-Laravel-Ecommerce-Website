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

Route::prefix('admin')->middleware('auth:admin')->group(function (){

    // settings
    Route::prefix('settings')->group(function (){
        // shipping
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-shipping']], function () {
            Route::get('denooj-shipping', 'DenoojShippingController@shipping')->name('settings.denooj-shipping');
            Route::patch('denooj-shipping/update/{settings}', 'DenoojShippingController@shippingUpdate')->name('settings.denooj-shipping_update');
        });
    });

});

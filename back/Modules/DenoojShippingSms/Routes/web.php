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
        // sms
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-sms']], function () {
            Route::get('denooj-sms', 'DenoojShippingSmsController@sms')->name('settings.denooj-sms');
            Route::post('denooj-sms/update/{settings}', 'DenoojShippingSmsController@smsUpdate')->name('settings.denooj-sms_update');
        });
    });
});



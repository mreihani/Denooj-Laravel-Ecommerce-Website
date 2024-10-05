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
Route::prefix('admin')->middleware(['auth:admin'])->group(function (){

    // admin orders filter routes, built for denooj.com specifically
    Route::get('orders/filter','Admin\OrdersFilterController@filter')->name('orders.filter');
    Route::get('orders/export-excel','Admin\OrdersFilterController@exportExcel')->name('orders.export-excel');
    Route::post('orders/change-order-status','Admin\OrdersFilterController@changeOrderStatus')->name('orders.change-order-status');

    // admin orders routes
    Route::get('orders/trash','Admin\OrdersController@trash')->name('orders.trash');
    Route::post('orders/restore', 'Admin\OrdersController@restore')->name('orders.restore');
    Route::post('orders/force-delete', 'Admin\OrdersController@forceDelete')->name('orders.forceDelete');
    Route::post('orders/search', 'Admin\OrdersController@search')->name('orders.search');
    Route::post('orders/search/trash', 'Admin\OrdersController@searchTrash')->name('orders.search.trash');
    Route::get('orders/shipping/{order}', 'Admin\OrdersController@editShipping')->name('orders.edit_shipping');
    Route::post('orders/shipping-update/{order}', 'Admin\OrdersController@updateShipping')->name('orders.update_shipping');
    Route::get('orders/{order}/factor','Admin\OrdersController@factor')->name('orders.factor');
    Route::get('orders/{order}/label','Admin\OrdersController@label')->name('orders.label');
    Route::resource('orders', 'Admin\OrdersController');
    Route::post('orders/ajax-delete', 'Admin\OrdersController@ajaxDelete');
});

// user
Route::prefix('panel')->middleware(['auth','active'])->group(function () {
    Route::post('order/store','OrderController@store')->name('order.store');
    Route::get('orders','OrderController@index')->name('order.index');
    Route::get('orders/{order}','OrderController@show')->name('order.show');
    Route::post('orders/{order}/repay','OrderController@repay')->name('order.repay');
    Route::get('orders/{order}/factor','OrderController@factor')->name('order.factor');
});


/***********************************
 ******** Payment Routes ***********
 **********************************/
Route::get('/callback/zarinpal/order','OrderController@zarinpalCallback'); // Zarinpal
Route::get('/callback/zibal/order', 'OrderController@zibalCallback'); // Zibal
Route::get('/callback/nextpay/order', 'OrderController@nextpayCallback'); // nextpay
Route::get('/callback/pasargad/order', 'OrderController@pasargadCallback'); // pasargad
Route::get('/callback/idpay/order', 'OrderController@idpayCallback'); // IDPay
Route::post('/callback/parsian/order', 'OrderController@parsianCallback'); // Parsian
Route::post('/callback/mellat/order', 'OrderController@mellatCallback'); // Mellat

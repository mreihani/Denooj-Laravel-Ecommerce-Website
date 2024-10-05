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

Route::prefix('panel')->middleware(['auth','active'])->group(function () {
    Route::get('wallet', 'WalletController@index')->name('panel.wallet');
    Route::post('wallet/deposit', 'WalletController@deposit')->name('panel.wallet_deposit');
    Route::get('wallet/payment-result/{walletPayment}', 'WalletController@paymentResult')->name('panel.payment_result');
});

/***********************************
 ******** Payment Routes ***********
 **********************************/
Route::get('/callback/zarinpal', 'WalletController@zarinpalCallback'); // Zarinpal
Route::get('/callback/zibal', 'WalletController@zibalCallback'); // Zibal
Route::get('/callback/nextpay', 'WalletController@nextpayCallback'); // Nextpay
Route::get('/callback/idpay', 'WalletController@idpayCallback'); // IDPay
Route::post('/callback/parsian', 'WalletController@parsianCallback'); // Parsian
Route::post('/callback/mellat', 'WalletController@mellatCallback'); // Mellat

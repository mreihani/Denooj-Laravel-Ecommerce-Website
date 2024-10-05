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
        // general
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-general']], function () {
            Route::get('general', 'settingscontroller@general')->name('settings.general');
            Route::post('general/update', 'settingscontroller@generalUpdate')->name('settings.general_update');
        });
        // appearance
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-appearance']], function () {
            Route::get('appearance', 'settingscontroller@appearance')->name('settings.appearance');
            Route::post('appearance/update', 'settingscontroller@appearanceUpdate')->name('settings.appearance_update');
        });
        // header
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-header']], function () {
            Route::get('header', 'settingscontroller@header')->name('settings.header');
            Route::post('header/update', 'settingscontroller@headerUpdate')->name('settings.header_update');
        });
        // footer
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-footer']], function () {
            Route::get('footer', 'settingscontroller@footer')->name('settings.footer');
            Route::post('footer/update', 'settingscontroller@footerUpdate')->name('settings.footer_update');
        });
        // signin
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-signin']], function () {
            Route::get('signin', 'settingscontroller@signin')->name('settings.signin');
            Route::post('signin/update', 'settingscontroller@signinUpdate')->name('settings.signin_update');
        });
        // shipping
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-shipping']], function () {
            Route::get('shipping', 'settingscontroller@shipping')->name('settings.shipping');
            Route::post('shipping/update', 'settingscontroller@shippingUpdate')->name('settings.shipping_update');
        });
        // payment
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-payment']], function () {
            Route::get('payment', 'settingscontroller@payment')->name('settings.payment');
            Route::post('payment/update', 'settingscontroller@paymentUpdate')->name('settings.payment_update');
        });
        // sms
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-sms']], function () {
            Route::get('sms', 'settingscontroller@sms')->name('settings.sms');
            Route::post('sms/update', 'settingscontroller@smsUpdate')->name('settings.sms_update');
        });
        // factor
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-factor']], function () {
            Route::get('factor', 'settingscontroller@factor')->name('settings.factor');
            Route::post('factor/update', 'settingscontroller@factorUpdate')->name('settings.factor_update');
        });
        // notifications
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-notifications']], function () {
            Route::get('notifications', 'settingscontroller@notifications')->name('settings.notifications');
            Route::post('notifications/update', 'settingscontroller@notificationsUpdate')->name('settings.notifications_update');
        });
        // seo
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-seo']], function () {
            Route::get('seo', 'settingscontroller@seo')->name('settings.seo');
            Route::post('seo/update', 'settingscontroller@seoUpdate')->name('settings.seo_update');
        });
        // advanced
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-advanced']], function () {
            Route::get('advanced', 'settingscontroller@advanced')->name('settings.advanced');
            Route::post('advanced/update', 'settingscontroller@advancedUpdate')->name('settings.advanced_update');
        });
        // config
        Route::group(['middleware' => ['role_or_permission:super-admin|edit-setting-config']], function () {
            Route::get('config', 'settingscontroller@config')->name('settings.config');
            Route::post('config/update', 'settingscontroller@configUpdate')->name('settings.config_update');
            Route::post('config/mail-test', 'settingscontroller@testMail')->name('settings.test_mail');

        });
    });

});

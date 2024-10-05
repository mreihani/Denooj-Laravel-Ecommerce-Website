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

// admin
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth:admin'])->group(function (){
    Route::post('users/{user}/update-password', 'Admin\UsersController@updatePassword')->name('users.password_update');
    Route::post('users/{user}/balance-update','Admin\UsersController@updateBalance')->name('users.balance_update');
    Route::get('users/{user}/balance', 'Admin\UsersController@showBalance')->name('users.balance');
    Route::get('users/{user}/security','Admin\UsersController@showSecurity')->name('users.show_security');
    Route::get('users/{user}/addresses','Admin\UsersController@showAddresses')->name('users.show_addresses');
    Route::get('users/{user}/payments','Admin\UsersController@showPayments')->name('users.show_payments');
    Route::resource('users', 'Admin\UsersController');
    Route::post('users/search', 'Admin\UsersController@search')->name('users.search');
});

Route::prefix('panel')->middleware(['auth','active'])->group(function () {
    Route::get('overview', 'UserPanelController@overview')->name('panel.overview');
    Route::get('edit', 'UserPanelController@edit')->name('panel.edit');
    Route::post('update', 'UserPanelController@updateUser')->name('panel.update');

    // change password
    Route::get('reset-password', 'UserPanelController@resetPassword')->name('panel.reset_password');
    Route::post('update-password', 'UserPanelController@updatePassword')->name('panel.update_password');
    Route::get('verify-password', 'UserPanelController@verifyPassword')->name('panel.verify_password');
    Route::post('do-verify-password', 'UserPanelController@doVerifyPassword')->name('panel.do_verify_password');

    // addresses
    Route::get('addresses', 'UserPanelController@addresses')->name('panel.addresses');
    Route::post('get-cities', 'AddressController@getCities');
    Route::post('addresses/create', 'AddressController@store')->name('address.create');
    Route::post('addresses/delete/{id}', 'AddressController@delete')->name('address.delete');
    Route::get('addresses/edit/{id}', 'AddressController@edit')->name('address.edit');
    Route::post('addresses/update/{address}', 'AddressController@update')->name('address.update');

    // product favorites
    Route::get('favorites/product', 'UserPanelController@favorites')->name('panel.favorites');
    Route::post('favorites/product/remove', 'UserPanelController@removeFavorite');
    Route::post('favorites/product/toggle', 'UserPanelController@toggleFavorite');

    // post favorites
    Route::get('favorites/post', 'UserPanelController@favoritesPost')->name('panel.favorites_post');
    Route::post('favorites/post/toggle', 'UserPanelController@toggleFavoritePost');
});


/***********************************
 ******** Auth Routes **************
 **********************************/
Route::get('/login','AuthController@signin')->name('login')->middleware('guest');
Route::get('/signin','AuthController@signin')->name('signin')->middleware('guest');
Route::post('/do-signin','AuthController@doSignin')->name('doSignin');
Route::get('/login/with-password','AuthController@loginWithPassword')->name('login.with_password')->middleware('guest');
Route::post('/login/do-with-password','AuthController@doLoginWithPassword')->name('doLoginWithPassword');
Route::get('/login/with-email','AuthController@loginWithEmail')->name('login.with_email')->middleware('guest');
Route::post('/login/do-with-email','AuthController@doLoginWithEmail')->name('doLoginWithEmail');
Route::get('/verify','AuthController@verify')->name('verify')->middleware('guest');
Route::post('/do-verify','AuthController@doVerify')->name('doVerify')->middleware('guest');
Route::get('/logout','AuthController@logout')->name('logout');
Route::get('set-password','AuthController@setPassword')->name('set_password')->middleware('auth');
Route::post('reset-password','AuthController@resetPassword')->name('reset_password')->middleware('auth');
Route::post('/resend-code','AuthController@resendAuthCode')->middleware('guest');


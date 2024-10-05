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

Route::prefix('admin/tools')->middleware('auth:admin')->group(function() {
    Route::group(['middleware' => ['role_or_permission:super-admin|manage-redirects']], function () {
        Route::post('redirects/search','RedirectsController@search')->name('redirects.search');
        Route::resource('redirects', 'RedirectsController');
    });
});

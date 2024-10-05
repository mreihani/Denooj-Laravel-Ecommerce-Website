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

Route::prefix('admin')->middleware('auth:admin')->group(function() {

    // admins
    Route::group(['middleware' => ['role_or_permission:super-admin|manage-admins']], function () {
        Route::resource('admins','AdminsController');
        Route::post('admins/delete-form/{admin}','AdminsController@deleteForm')->name('admins.delete_form');
        Route::post('admins/search','AdminsController@search')->name('admins.search');
    });

    // roles and permissions
    Route::group(['middleware' => ['role_or_permission:super-admin|manage-permissions']], function () {
        Route::resource('roles', 'RolesController');
        Route::post('roles/search','RolesController@search')->name('roles.search');
        Route::resource('permissions', 'PermissionsController');
        Route::post('permissions/search','PermissionsController@search')->name('permissions.search');
    });
});

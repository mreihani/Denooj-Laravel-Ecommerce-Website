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

// post categories
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth:admin')->group(function() {

    Route::group(['middleware' => ['role_or_permission:super-admin|filemanager-access']], function () {
        Route::get('files/search','Admin\FilesController@search')->name('files.search');
        Route::resource('files','Admin\FilesController');
    });

});


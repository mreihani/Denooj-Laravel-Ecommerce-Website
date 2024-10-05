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

Route::prefix('admin')->group(function () {
    Route::group(['middleware' => ['role_or_permission:super-admin|manage-menus','auth:admin']], function () {
        Route::post('menus/ajax-items-update', 'MenusController@ajaxUpdateItems');
        Route::resource('menus', 'MenusController');
        Route::post('menus/get-items','MenuItemsController@getItems');
        Route::post('menu-items/update','MenuItemsController@ajaxUpdate');
        Route::post('menu-items/delete','MenuItemsController@ajaxDelete');
        Route::post('menu-items/bulk-delete','MenuItemsController@ajaxBulkDelete');
        Route::post('menu-items/create', 'MenuItemsController@ajaxCreate');
    });
});

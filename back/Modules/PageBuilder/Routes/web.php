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

use App\Http\Controllers\Front\IndexController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth:admin')->group(function() {
    Route::group(['middleware' => ['role_or_permission:super-admin|manage-templates']], function () {
        Route::post('templates/search','TemplatesController@search')->name('templates.search');
        Route::resource('templates', 'TemplatesController');
        Route::post('templates/{id}/add-row','TemplatesController@addRow');
        Route::post('templates/delete-row','TemplatesController@deleteRow');
        Route::post('templates/{row}/update-row','TemplatesController@updateRow')->name('template.update_row');
        Route::post('templates/update-row-index','TemplatesController@updateRowOrder');
    });
});

Route::get('template/{template}/preview', [IndexController::class,'previewTemplate'])->name('template.preview');

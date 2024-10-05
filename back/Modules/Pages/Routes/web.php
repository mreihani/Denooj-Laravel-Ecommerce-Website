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
$migrated = \Illuminate\Support\Facades\DB::table('migrations')
    ->where('migration','2023_07_25_103513_create_seo_settings_table')->first();
if ($migrated){
    $seoSetting = \Modules\Settings\Entities\SeoSetting::firstOrCreate();
    Route::get("/$seoSetting->page_base/{page}/", 'PageController@show')->name('page.show');
}

Route::prefix('admin')->middleware('auth:admin')->group(function() {

    Route::get('pages/trash', 'Admin\PagesController@trash')->name('pages.trash');
    Route::post('pages/empty/trash','Admin\PagesController@emptyTrash')->name('pages.trash.empty');
    Route::post('pages/restore/{id}','Admin\PagesController@restore')->name('pages.restore');
    Route::post('pages/force-delete','Admin\PagesController@forceDelete')->name('pages.delete.force');
    Route::post('pages/search/trash','Admin\PagesController@searchTrash')->name('pages.search.trash');
    Route::post('pages/search','Admin\PagesController@search')->name('pages.search');
    Route::resource('pages', 'Admin\PagesController');
    Route::post('pages/ajax-delete','Admin\PagesController@ajaxDelete');

});


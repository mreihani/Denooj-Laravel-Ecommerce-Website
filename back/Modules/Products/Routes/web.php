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

    // products
    Route::get('products/search', 'Admin\ProductsController@search')->name('products.search');
    Route::get('products/trash','Admin\ProductsController@trash')->name('products.trash');
    Route::post('products/empty/trash', 'Admin\ProductsController@emptyTrash')->name('products.trash.empty');
    Route::post('products/restore/{id}', 'Admin\ProductsController@restore')->name('products.restore');
    Route::post('products/force-delete', 'Admin\ProductsController@forceDelete')->name('products.delete.force');
    Route::post('products/search/trash', 'Admin\ProductsController@searchTrash')->name('products.search.trash');
    Route::resource('products', 'Admin\ProductsController');
    Route::post('products/duplicate/{product}', 'Admin\ProductsController@duplicate')->name('products.duplicate');
    Route::post('products/ajax-delete', 'Admin\ProductsController@ajaxDelete');

    // categories
    Route::group(['middleware' => ['role_or_permission:super-admin|manage-categories']], function () {
        Route::get('categories/search', 'Admin\CategoriesController@search')->name('categories.search');
        Route::resource('categories', 'Admin\CategoriesController');
    });

    // attributes
    Route::group(['middleware' => ['role_or_permission:super-admin|manage-attributes']], function () {
        Route::resource('attributes', 'Admin\AttributesController');
        Route::post('attributes/search', 'Admin\AttributesController@search')->name('attributes.search');
        Route::resource('attribute-categories', 'Admin\AttributeCategoriesController');
        Route::post('attribute-categories/search', 'Admin\AttributeCategoriesController@search')->name('attribute-categories.search');
        Route::post('get-cat-attributes', 'Admin\AttributeCategoriesController@getAttributes');
        Route::resource('attribute-values', 'Admin\AttributeValuesController');
        Route::post('attribute-values/search', 'Admin\AttributeValuesController@search')->name('attribute-values.search');
    });

    // tags
    Route::group(['middleware' => ['role_or_permission:super-admin|manage-tags']], function () {
        Route::post('tags/search','Admin\TagsController@search')->name('tags.search');
        Route::resource('tags', 'Admin\TagsController');
    });

    // product colors
    Route::group(['middleware' => ['role_or_permission:super-admin|manage-product-colors']], function () {
        Route::post('product-colors/search','Admin\ProductColorsController@search')->name('product-colors.search');
        Route::resource('product-colors', 'Admin\ProductColorsController');
    });

    // product sizes
    Route::group(['middleware' => ['role_or_permission:super-admin|manage-product-sizes']], function () {
        Route::post('product-sizes/search','Admin\ProductSizesController@search')->name('product-sizes.search');
        Route::resource('product-sizes', 'Admin\ProductSizesController');
    });
});

$migrated = \Illuminate\Support\Facades\DB::table('migrations')
    ->where('migration','2023_07_25_103513_create_seo_settings_table')->first();
if ($migrated){
    $seoSetting = \Modules\Settings\Entities\SeoSetting::firstOrCreate();
    Route::get("/$seoSetting->product_base/{product}/", 'ProductsController@product')->name('product.show');
    Route::get("/$seoSetting->category_base/{category}/", 'ProductsController@showCategory')->name('category.show');
    Route::get("/$seoSetting->tag_base/{tag}/", 'ProductsController@tag')->name('tag.show');
    Route::get("/products/",'ProductsController@products')->name('products');
    Route::get("/p/{code}/", 'ProductsController@productShortUrl')->name('product.short_url');
    Route::get("/search/",'ProductsController@search')->name('search');
    Route::post("/get-inventory/",'ProductsController@getInventory');
}



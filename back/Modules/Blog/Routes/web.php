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
    Route::get("/blog", 'BlogController@index')->name('blog');
    Route::get("/$seoSetting->post_base/{post}/", 'BlogController@show')->name('post.show');
    Route::get("/$seoSetting->post_category_base/{category}/",'BlogController@postCategory')->name('post_category.show');
    Route::get("/$seoSetting->post_tag_base/{tag}/",'BlogController@postTag')->name('post_tag.show');
}

Route::prefix('admin')->middleware('auth:admin')->group(function() {
    Route::get('posts/trash', 'Admin\PostsController@trash')->name('posts.trash');
    Route::post('posts/empty/trash','Admin\PostsController@emptyTrash')->name('posts.trash.empty');
    Route::post('posts/restore/{id}','Admin\PostsController@restore')->name('posts.restore');
    Route::post('posts/force-delete','Admin\PostsController@forceDelete')->name('posts.delete.force');
    Route::post('posts/search/trash','Admin\PostsController@searchTrash')->name('posts.search.trash');
    Route::post('posts/search','Admin\PostsController@search')->name('posts.search');
    Route::resource('posts', 'Admin\PostsController');
    Route::post('posts/ajax-delete','Admin\PostsController@ajaxDelete');

    // categories
    Route::group(['middleware' => ['role_or_permission:super-admin|manage-post-categories']], function () {
        Route::post('post-categories/search', 'Admin\PostCategoriesController@search')->name('post-categories.search');
        Route::resource('post-categories','Admin\PostCategoriesController');
    });

    // tags
    Route::group(['middleware' => ['role_or_permission:super-admin|manage-post-tags']], function () {
        Route::post('post-tags/search','Admin\TagsController@search')->name('post-tags.search');
        Route::resource('post-tags', 'Admin\TagsController');
    });
});

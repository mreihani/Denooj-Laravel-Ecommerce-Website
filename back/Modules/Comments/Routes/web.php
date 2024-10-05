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

Route::prefix('admin')->middleware(['role_or_permission:super-admin|manage-comments','auth:admin'])->group(function (){
    Route::post('comments/search','Admin\CommentsController@search')->name('comments.search');
    Route::post('comments/approved', 'Admin\CommentsController@approved');
    Route::post('comments/unapproved', 'Admin\CommentsController@unapproved');
    Route::post('comments/delete', 'Admin\CommentsController@delete');
    Route::resource('comments', 'Admin\CommentsController');
});


Route::prefix('panel')->middleware(['auth','active'])->group(function () {
    Route::post('comment/add','CommentsController@addComment')->name('add_comment');
    Route::post('comment/post/add','CommentsController@addCommentForPost')->name('add_comment_post');
});

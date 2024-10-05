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

// admin
Route::prefix('admin')->middleware(['role_or_permission:super-admin|manage-questions','auth:admin'])->group(function (){
    Route::post('questions/search', 'Admin\QuestionsController@search')->name('questions.search');
    Route::post('questions/approved', 'Admin\QuestionsController@approved');
    Route::post('questions/unapproved', 'Admin\QuestionsController@unapproved');
    Route::post('questions/delete', 'Admin\QuestionsController@delete');
    Route::post('questions/response', 'Admin\QuestionsController@addResponse')->name('questions.add_response');
    Route::resource('questions', 'Admin\QuestionsController');
});

// front
Route::prefix('panel')->middleware(['auth','active'])->group(function () {
    Route::post('question/submit/{product}','QuestionsController@submitQuestion')->name('submit_question');
});

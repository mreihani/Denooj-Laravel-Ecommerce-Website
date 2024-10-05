<?php
use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')->middleware(['role_or_permission:super-admin|manage-stories','auth:admin'])->group(function (){
    Route::post('stories/search','Admin\StoryController@search')->name('stories.search');
    Route::resource('stories', 'Admin\StoryController');
});

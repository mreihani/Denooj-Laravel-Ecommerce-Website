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

Route::prefix('admin')->middleware(['role_or_permission:super-admin|manage-tickets','auth:admin'])->group(function (){
    Route::post('tickets/search','Admin\TicketsController@search')->name('tickets.search');
    Route::post('tickets/response/add/{ticket}','Admin\TicketsController@addResponse')->name('tickets.add_response');
    Route::resource('tickets', 'Admin\TicketsController');
});

Route::prefix('panel')->middleware(['auth','active'])->group(function () {
    Route::get('tickets','TicketController@index')->name('panel.tickets');
    Route::get('tickets/show/{ticket}','TicketController@show')->name('panel.tickets.show');
    Route::post('tickets/store','TicketController@store')->name('panel.tickets.store');
    Route::post('tickets/response/add/{ticket}','TicketController@addResponse')->name('panel.tickets.add_response');
});


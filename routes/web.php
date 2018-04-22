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

Route::get('/', 'HomeController@handle');

Route::group([
//    'middleware' => 'spotify'
], function () {
    Route::get('callback', 'CallbackController@handle');
    Route::get('playing', 'PlayingController@handle')->name('playing');
    Route::get('playing/fetch', 'PlayingController@fetch');
});

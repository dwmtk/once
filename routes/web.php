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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/event/list/{category}', 'EventController@list');
Route::get('/event/detail/{event_id}', 'EventController@detail')->name('event/detail');
Route::post('/event/end', 'HomeController@attend');
Route::post('/event/quit', 'HomeController@quit');

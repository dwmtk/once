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
Route::get('/home/edit', 'HomeController@edit_get');
Route::post('/home/edit', 'HomeController@edit_post');
Route::get('/home/edit_password', 'HomeController@edit_password_get');
Route::post('/home/edit_password', 'HomeController@edit_password_post');

Route::get('/event/list/{category}', 'EventController@list');
Route::get('/event/detail/{event_id}', 'EventController@detail')->name('event/detail');
Route::post('/event/end', 'HomeController@attend');
Route::post('/event/quit', 'HomeController@quit');

Route::get('/manage/index', 'ManageController@index');
Route::get('/manage/insert', 'ManageController@insert_get');
Route::post('/manage/insert', 'ManageController@insert_post');
Route::get('/manage/update/{event_id}', 'ManageController@update_get');
Route::post('/manage/update', 'ManageController@update_post');
Route::get('/manage/stop', 'ManageController@stop');
Route::get('/manage/member_list', 'ManageController@member_list');
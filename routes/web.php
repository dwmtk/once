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

Route::get('/', 'EventController@top');
Route::get('/privacy_policy', function(){
    return view('/privacy_policy');
});
Route::get('/terms_of_service', function(){
    return view('/terms_of_service');
});

Auth::routes();

// ホーム画面
Route::get('/home', 'HomeController@index')->name('home');

// ユーザ情報
Route::get('/home/edit', 'UserController@edit_get');
Route::post('/home/edit', 'UserController@edit_post');
Route::get('/home/edit_password', 'UserController@edit_password_get');
Route::post('/home/edit_password', 'UserController@edit_password_post');

// イベント表示
Route::get('/event/list/{category}', 'EventController@list');
Route::get('/event/detail/{event_id}', 'EventController@detail')->name('event/detail');

// イベント参加・欠席
Route::post('/event/end', 'AttendController@attend');
Route::post('/event/quit', 'AttendController@quit');

// 管理者機能
Route::get('/manage/index', 'ManageController@index');
Route::get('/manage/insert', 'ManageController@insert_get');
Route::post('/manage/insert', 'ManageController@insert_post');
Route::get('/manage/update/{event_id}', 'ManageController@update_get');
Route::post('/manage/update', 'ManageController@update_post');
Route::post('/manage/stop', 'ManageController@stop');
Route::get('/manage/member_list', 'ManageController@member_list');
Route::get('/manage/howto', 'ManageController@howto');
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
    return redirect('login');
});

/*Route::get('/', function () {
    return view('welcome');
});*/

// 暂时不需要整个认证所有操作，只需要保留登录和登出
//Auth::routes();

Route::group(['namespace'=>'Auth'],function(){
    Route::get('login','LoginController@showLoginForm');
    Route::post('login','LoginController@login')->name('login');
    Route::post('logout','LoginController@logout');
});


Route::group(['namespace'=>'Backend','prefix'=>'backend','middleware'=>'backendAuth'],function(){
    Route::get('/home', 'HomeController@index')->name('home');

    // 后台用户
    Route::get('/users', 'UsersController@index');
    Route::get('/users/create', 'UsersController@create');
    Route::post('/users/store', 'UsersController@store');
    Route::post('/users/check', 'UsersController@check');// 通过审核
    Route::post('/users/delete', 'UsersController@delete');// 删除
    Route::get('/users/{id}', 'UsersController@show');
    Route::post('/users/{id}', 'UsersController@update');
    
});
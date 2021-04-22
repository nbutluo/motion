<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
|--------------------------------------------------------------------------
| 后台公共页面
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {
    //后台布局
    Route::get('/', 'Admin\IndexController@layout')->name('admin.layout');
    //后台首页
    Route::get('/index', 'Admin\IndexController@index')->name('admin.index');
});

/*
|--------------------------------------------------------------------------
| 用户登录、退出、更改密码
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'user'], function() {
    Route::get('login','Admin\LoginController@showLoginForm')->name('admin.user.loginForm');
    Route::post('logindata','Admin\LoginController@login')->name('admin.user.login');
});

//Route::group(['middleware' => ['auth']], function () {
//    //后台布局
//    Route::get('/', \App\Http\Controllers\Admin\IndexController::class . '@layout')->name('admin.layout');
//    //后台首页
//    Route::get('/index', \App\Http\Controllers\Admin\IndexController::class . '@index')->name('admin.index');
//});

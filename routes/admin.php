<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::get('logout', 'Admin\LoginController@logout')->name('admin.user.logout')->middleware('auth');
    //修改密码
    Route::get('change_my_password_form', 'Admin\PasswordController@changeMyPasswordForm')->name('admin.user.changeMyPasswordForm')->middleware('auth');
    Route::post('change_my_password', 'Admin\PasswordController@changeMyPassword')->name('admin.user.changeMyPassword')->middleware('auth');
    //个人资料
    Route::get('information_form', 'Admin\InformationController@myForm')->name('admin.user.myForm')->middleware('auth');
    Route::post('information_update','Admin\InformationController@infoUpdate')->name('admin.user.infoUpdate')->middleware('auth');
});

Route::group(['namespace' => 'Admin'], function () {
    // seo 获取与更新
    Route::get('website-seo', 'SystemConfigController@getSeoInfo');
    Route::post('website-seo-update', 'SystemConfigController@updateSeoConfig');

    // blog 系列接口
    Route::get('blog-list', 'BlogController@getList');
    Route::get('blog/{id}', 'BlogController@getPost');
    Route::post('blog-add', 'BlogController@addPost');
    Route::post('blog-update', 'BlogController@updatePost');
    // blog分类 系列接口
    Route::get('blog-category-list', 'BlogCategoryController@getList');
    Route::get('blog/category/{id}', 'BlogCategoryController@getCategory');
    Route::post('blog-category-add', 'BlogCategoryController@addCategory');
    Route::post('blog-category-update', 'BlogCategoryController@updateCategory');

    Route::post('blog-category-contact', 'BlogController@contactPostCategory');
});

//Route::group(['middleware' => ['auth']], function () {
//    //后台布局
//    Route::get('/', \App\Http\Controllers\Admin\IndexController::class . '@layout')->name('admin.layout');
//    //后台首页
//    Route::get('/index', \App\Http\Controllers\Admin\IndexController::class . '@index')->name('admin.index');
//});

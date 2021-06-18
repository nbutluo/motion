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
    Route::get('login','Admin\LoginController@showLoginForm')->name('admin.user.login');
    Route::post('logindata','Admin\LoginController@login')->name('admin.user.login-post');
    Route::get('logout', 'Admin\LoginController@logout')->name('admin.user.logout')->middleware('auth');
    //修改密码
    Route::get('change_my_password_form', 'Admin\PasswordController@changeMyPasswordForm')->name('admin.user.changeMyPasswordForm')->middleware('auth');
    Route::post('change_my_password', 'Admin\PasswordController@changeMyPassword')->name('admin.user.changeMyPassword')->middleware('auth');
    //个人资料
    Route::get('information_form', 'Admin\InformationController@myForm')->name('admin.user.myForm')->middleware('auth');
    Route::post('information_update','Admin\InformationController@infoUpdate')->name('admin.user.infoUpdate')->middleware('auth');
});

Route::group(['namespace' => 'Admin'], function () {
    Route::post('upload', 'UploadController@upload')->name('admin.upload');
    Route::post('upload.media', 'UploadController@uploadMedia')->name('admin.upload.media');
    Route::post('upload.product.medias', 'UploadController@uploadProductImages')->name('admin.upload.medias');
    Route::post('upload/blog/image', 'UploadController@uploadBlogImage')->name('admin.upload.blogImage');
});

Route::group(['namespace' => 'Admin'], function () {

    Route::get('contact/index', 'ContactUsController@index')->name('admin.contact');
    Route::get('contact/list', 'ContactUsController@getList')->name('admin.contact.data');
    Route::get('contact/detail/{id}', 'ContactUsController@detail')->name('admin.contact.detail');

});

//Route::group(['middleware' => ['auth']], function () {
//    //后台布局
//    Route::get('/', \App\Http\Controllers\Admin\IndexController::class . '@layout')->name('admin.layout');
//    //后台首页
//    Route::get('/index', \App\Http\Controllers\Admin\IndexController::class . '@index')->name('admin.index');
//});

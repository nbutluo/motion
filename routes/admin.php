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
});

Route::group(['namespace' => 'Admin'], function () {

    // blog 系列接口
    Route::get('blog-index', 'BlogController@index')->name('admin.blog.article');
    Route::get('blog-list', 'BlogController@getList')->name('admin.blog.article.data');
    Route::get('blog/{id}', 'BlogController@getPost');
    Route::get('blog-create', 'BlogController@create')->name('admin.blog.article.create');
    Route::post('blog/create', 'BlogController@addPost')->name('admin.blog.article.create-post');
    Route::get('blog/{id}/edit', 'BlogController@edit')->name('admin.blog.article.edit');
    Route::post('blog/{id}/update', 'BlogController@update')->name('admin.blog.article.update');
    Route::delete('blog/disable', 'BlogController@disable')->name('admin.blog.article.disable');

    // blog分类 系列接口
    Route::get('blog-category-index', 'BlogCategoryController@index')->name('admin.blog.category');
    Route::get('blog/category/list', 'BlogCategoryController@getList')->name('admin.blog.category.data');
    Route::get('blog/category/{id}', 'BlogCategoryController@getCategory');
    Route::get('blog/category/create', 'BlogCategoryController@create')->name('admin.blog.category.create');
    Route::post('blog/category/add', 'BlogCategoryController@addCategory')->name('admin.blog.category.create-post');
    Route::get('blog/category/{id}/edit', 'BlogCategoryController@edit')->name('admin.blog.category.edit');
    Route::post('blog/category/{id}/update', 'BlogCategoryController@update')->name('admin.blog.category.update');
    Route::delete('blog/category/disable', 'BlogCategoryController@disable')->name('admin.blog.category.disable');;

});

//Route::group(['middleware' => ['auth']], function () {
//    //后台布局
//    Route::get('/', \App\Http\Controllers\Admin\IndexController::class . '@layout')->name('admin.layout');
//    //后台首页
//    Route::get('/index', \App\Http\Controllers\Admin\IndexController::class . '@index')->name('admin.index');
//});

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 后台路由
|--------------------------------------------------------------------------
|
| 统一命名空间 Admin
| 统一前缀 admin
| 用户认证统一使用 auth 中间件
| 权限认证统一使用 permission:权限名称
|
*/

/*
|--------------------------------------------------------------------------
| 资讯管理模块
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth', 'permission:information']],function() {
    //blog分类管理
    Route::group(['middleware' => ['permission:information.category']], function() {
        Route::group(['namespace' => 'Admin'], function () {
            // blog分类 系列接口
            Route::get('blog/category/index', 'BlogCategoryController@index')->name('admin.blog.category');
            Route::get('blog/category/list', 'BlogCategoryController@getList')->name('admin.blog.category.data');
            Route::get('blog/category/{id}', 'BlogCategoryController@getCategory');
            //添加分类
            Route::get('blog/category/create', 'BlogCategoryController@create')->name('admin.blog.category.create')->middleware('permission:information.category.create');
            Route::post('blog/category/add', 'BlogCategoryController@addCategory')->name('admin.blog.category.create-post')->middleware('permission:information.category.create');
            //分类编辑
            Route::get('blog/category/{id}/edit', 'BlogCategoryController@edit')->name('admin.blog.category.edit')->middleware('permission:information.category.edit');
            Route::post('blog/category/{id}/update', 'BlogCategoryController@update')->name('admin.blog.category.update')->middleware('permission:information.category.edit');
            //禁用分类
            Route::delete('blog/category/disable', 'BlogCategoryController@disable')->name('admin.blog.category.disable');

        });
    });

    //blog管理
    Route::group(['middleware' => ['permission:information.article']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            // blog 系列接口
            Route::get('blog/index', 'BlogController@index')->name('admin.blog.article');
            Route::get('blog/list', 'BlogController@getList')->name('admin.blog.article.data');
            Route::get('blog/{id}', 'BlogController@getPost');
            Route::get('blog/create', 'BlogController@create')->name('admin.blog.article.create');
            Route::post('blog/create', 'BlogController@addPost')->name('admin.blog.article.create-post');
            Route::get('blog/{id}/edit', 'BlogController@edit')->name('admin.blog.article.edit');
            Route::post('blog/{id}/update', 'BlogController@update')->name('admin.blog.article.update');
            Route::delete('blog/disable', 'BlogController@disable')->name('admin.blog.article.disable');
        });
    });
});

//FAQ管理
Route::group(['middleware' => ['auth', 'permission:faq']],function() {
    Route::group(['middleware' => ['permission:faq.info']],function(){
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('faq/index','FaqController@index')->name('admin.faq.info');
            Route::get('faq/list','FaqController@data')->name('admin.faq.info.data');
            //添加
            Route::get('faq/create','FaqController@create')->name('admin.faq.create')->middleware('permission:faq.info.create');
            Route::post('faq/getData','FaqController@getData')->name('admin.faq.getData');
        });
    });
});

//联系我们管理
Route::group(['middleware' => ['auth', 'permission:contact']],function() {
    Route::group(['middleware' => ['permission:contact.list']],function(){
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('contact/index','ContactUsController@index')->name('admin.contact.list');
        });
    });
});

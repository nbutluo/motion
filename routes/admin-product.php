<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'permission:catalog']],function() {
    //产品分类
    Route::group(['middleware' => ['auth', 'permission:catalog.category']],function (){
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('catalog/category/index','ProductCategoryController@index')->name('admin.catalog.category');
            Route::get('catalog/category/data','ProductCategoryController@getList')->name('admin.catalog.category.data');
            //添加分类
            Route::get('catalog/category/create','ProductCategoryController@create')->name('admin.catalog.category.create')->middleware('permission:catalog.category.create');
            Route::post('catalog/category/store','ProductCategoryController@store')->name('admin.catalog.category.store')->middleware('permission:catalog.category.create');
            //编辑分类
            Route::get('catalog/category/{id}/edit','ProductCategoryController@edit')->name('admin.catalog.category.edit')->middleware('permission:catalog.category.edit');
            Route::post('catalog/category/{id}/update','ProductCategoryController@update')->name('admin.catalog.category.update')->middleware('permission:catalog.category.edit');
        });
    });

    //产品
    Route::group(['middleware' => ['auth', 'permission:catalog.product']],function (){
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('product/index', 'ProductController@index')->name('admin.catalog.product');
            Route::get('product/list', 'ProductController@getList')->name('admin.catalog.product.data');
            Route::get('product/detail/{id}/edit', 'ProductController@edit')->name('admin.catalog.product.edit');
            Route::post('product/detail/{id}/update', 'ProductController@update')->name('admin.catalog.product.update');
            Route::get('product/create', 'ProductController@create')->name('admin.catalog.product.create');
            Route::post('product/create', 'ProductController@addProduct')->name('admin.blog.article.create.post');
        });
    });
});

<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin'], function () {

    Route::get('product/index', 'ProductController@index')->name('admin.catalog.product');
    Route::get('product/list', 'ProductController@getList')->name('admin.catalog.product.data');
    Route::get('product/detail/{id}/edit', 'ProductController@edit')->name('admin.catalog.product.edit');
    Route::post('product/detail/{id}/update', 'ProductController@update')->name('admin.catalog.product.update');
    Route::get('product/create', 'ProductController@create')->name('admin.catalog.product.create');
    Route::post('product/create', 'ProductController@addProduct')->name('admin.blog.article.create.post');

});

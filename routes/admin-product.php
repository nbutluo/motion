<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'permission:catalog']], function () {
    //产品分类
    Route::group(['middleware' => ['auth', 'permission:catalog.category']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('catalog/category/index', 'ProductCategoryController@index')->name('admin.catalog.category');
            Route::get('catalog/category/data', 'ProductCategoryController@getList')->name('admin.catalog.category.data');
            //添加分类
            Route::get('catalog/category/create', 'ProductCategoryController@create')->name('admin.catalog.category.create')->middleware('permission:catalog.category.create');
            Route::post('catalog/category/store', 'ProductCategoryController@store')->name('admin.catalog.category.store')->middleware('permission:catalog.category.create');
            //编辑分类
            Route::get('catalog/category/{id}/edit', 'ProductCategoryController@edit')->name('admin.catalog.category.edit')->middleware('permission:catalog.category.edit');
            Route::post('catalog/category/{id}/update', 'ProductCategoryController@update')->name('admin.catalog.category.update')->middleware('permission:catalog.category.edit');
            Route::get('product/category/{product?}', 'ProductCategoryController@getCategoryData')->name('admin.catalog.product.category.data');
        });
    });

    //产品
    Route::group(['middleware' => ['auth', 'permission:catalog.product']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('product/index', 'ProductController@index')->name('admin.catalog.product');
            Route::get('product/list', 'ProductController@getList')->name('admin.catalog.product.data');
            Route::get('product/detail/{id}/edit', 'ProductController@edit')->name('admin.catalog.product.edit');
            Route::post('product/detail/{id}/update', 'ProductController@update')->name('admin.catalog.product.update');
            Route::get('product/create', 'ProductController@create')->name('admin.catalog.product.create');
            Route::post('product/create', 'ProductController@addProduct')->name('admin.blog.article.create.post');
            Route::post('product/relate/list', 'ProductController@RelateProductList')->name('admin.catalog.product.relate.list');
            Route::get('product/set/list/{product}', [ProductController::class, 'SetProductList'])->name('admin.catalog.product.set.list');
            Route::post('product/{product}', 'ProductController@destroy')->name('admin.product.destroy');
            Route::get('product/new_arrival/index', 'NewArrivalController@index')->name('admin.new_arrival.index');
            Route::get('product/new_arrival/{product}/edit', 'NewArrivalController@edit')->name('admin.new_arrival.edit');
            Route::patch('product/new_arrival/{product}', 'NewArrivalController@update')->name('admin.new_arrival.update');
            Route::get('product/new_arrival/json', 'NewArrivalController@newArrival')->name('admin.new_arrival.data');
        });
    });

    //产品选项
    Route::group(['middleware' => ['auth', 'permission:catalog.product']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('product/option/index', 'ProductOptionController@index')->name('admin.catalog.option');
            Route::get('product/option/list', 'ProductOptionController@getList')->name('admin.catalog.option.data');
            Route::get('product/option/{id}/edit', 'ProductOptionController@edit')->name('admin.catalog.option.edit');
            Route::post('product/option/{id}/update', 'ProductOptionController@update')->name('admin.catalog.option.update');
            Route::get('product/option/create', 'ProductOptionController@create')->name('admin.catalog.option.create');
            Route::post('product/option/create', 'ProductOptionController@store')->name('admin.catalog.option.post');
        });
    });

    //订单管理
    Route::group(['middleware' => ['auth', 'permission:order']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('order/index', 'OrderController@index')->name('admin.order.index');
            Route::get('order/data', 'OrderController@getList')->name('admin.order.index.list');
            Route::get('order/{id}/edit', 'OrderController@edit')->name('admin.order.edit');
            Route::post('order/update', 'OrderController@update')->name('admin.order.update');
        });
    });
});

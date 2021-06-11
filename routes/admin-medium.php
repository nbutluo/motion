<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin'], function () {
    //资源分类
    Route::get('medium/category/index','MediumSourceCategoryController@index')->name('admin.medium.category.index')->middleware('permission:medium.category.list');
    Route::get('medium/category/index/data','MediumSourceCategoryController@getList')->name('admin.medium.category.index.data')->middleware('permission:medium.category.list');
//    Route::post('medium/category/data','MediumSourceCategoryController@categoryData')->name('admin.medium.category.data');
    Route::get('medium/category/create','MediumSourceCategoryController@create')->name('admin.medium.category.create')->middleware('permission:medium.category.create');
    Route::post('medium/category/add','MediumSourceCategoryController@add')->name('admin.medium.category.add')->middleware('permission:medium.category.create');
    Route::get('medium/category/{id}/edit','MediumSourceCategoryController@edit')->name('admin.medium.category.edit')->middleware('permission:medium.category.edit');
    Route::post('medium/category/update','MediumSourceCategoryController@update')->name('admin.medium.category.update')->middleware('permission:medium.category.edit');


    //总体资源模块
    Route::get('medium/index','MediumSourceController@index')->name('admin.medium.index');
    Route::get('medium/index/data','MediumSourceController@getList')->name('admin.medium.index.data');

    //添加资源
    Route::get('medium/source/create','MediumSourceController@create')->name('admin.medium.source.create');
    Route::post('medium/source/create','MediumSourceController@store')->name('admin.medium.source.store');

    //编辑资源
    Route::get('medium/source/{id}/edit','MediumSourceController@edit')->name('admin.medium.source.edit');
    Route::post('medium/source/{id}/update','MediumSourceController@update')->name('admin.medium.source.update');

    //资源下载
    Route::get('medium/source/download/{id}','MediumSourceController@download')->name('admin.medium.source.download');

    //视频资源模块
    Route::get('medium/video','MediumSourceController@video')->name('admin.medium.video');
    Route::get('medium/video/data','MediumSourceController@getList')->name('admin.medium.video.data');

    //质检文件模块
    Route::get('medium/qcfile','MediumSourceController@qcfile')->name('admin.medium.qcfile');
    Route::get('medium/qcfile/data','MediumSourceController@getList')->name('admin.medium.qcfile.data');

    //安装说明文件模块
    Route::get('medium/instruction','MediumSourceController@instruction')->name('admin.medium.instruction');
    Route::get('medium/instruction/data','MediumSourceController@getList')->name('admin.medium.instruction.data');

    //宣传册模块
    Route::get('medium/brochure','MediumSourceController@brochure')->name('admin.medium.brochure');
    Route::get('medium/brochure/data','MediumSourceController@getList')->name('admin.medium.brochure.data');

    //banner模块
    Route::group(['middleware' => ['auth', 'permission:banner']],function (){
        Route::get('banner/index','BannerController@index')->name('admin.banner.index');
        Route::get('banner/index/list','BannerController@getList')->name('admin.banner.index.list');
        Route::get('banner/create','BannerController@create')->name('admin.banner.create');
        Route::post('banner/add','BannerController@addBanner')->name('admin.banner.add');
        Route::get('banner/{id}/edit','BannerController@edit')->name('admin.banner.edit');
        Route::post('banner/{id}/update','BannerController@update')->name('admin.banner.update');
    });
});

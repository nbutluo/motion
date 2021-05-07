<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin'], function () {
    Route::get('medium/index','MediumSourceController@index')->name('admin.medium.index');
    Route::get('medium/index/data','MediumSourceController@getList')->name('admin.medium.index.data');
    //添加资源
    Route::get('medium/source/create','MediumSourceController@create')->name('admin.medium.source.create');
    Route::post('medium/source/create','MediumSourceController@store')->name('admin.medium.source.store');
    //资源下载
    Route::get('medium/source/download/{id}','MediumSourceController@download')->name('admin.medium.source.download');
    //编辑资源
    Route::get('medium/source/{id}/edit','MediumSourceController@edit')->name('admin.medium.source.edit');
    Route::post('medium/source/{id}/update','MediumSourceController@update')->name('admin.medium.source.update');
});

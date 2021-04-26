<?php

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
| 系统管理模块
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth', 'permission:system']],function() {
//    用户管理
    Route::group(['middleware' => ['permission:system.user']], function() {
        Route::get('user','Admin\User\UserController@index')->name('admin.user');
        Route::get('user/data','Admin\User\UserController@data')->name('admin.user.data');
//        删除用户
        Route::delete('user/destroy', 'Admin\User\UserController@destroy')->name('admin.user.destroy')->middleware('permission:system.user.destroy');
        //添加
        Route::get('user/create','Admin\User\UserController@create')->name('admin.user.create')->middleware('permission:system.user.create');
        Route::post('user/store','Admin\User\UserController@store')->name('admin.user.store')->middleware('permission:system.user.create');
        //分配角色
        Route::get('user/{id}/role', 'Admin\User\UserController@role')->name('admin.user.role')->middleware('permission:system.user.role');
        Route::put('user/{id}/assignRole', 'Admin\User\UserController@assignRole')->name('admin.user.assignRole')->middleware('permission:system.user.role');
        //分配权限
        Route::get('user/{id}/permission', 'Admin\User\UserController@permission')->name('admin.user.permission')->middleware('permission:system.user.permission');
        Route::put('user/{id}/assignPermission', 'Admin\User\UserController@assignPermission')->name('admin.user.assignPermission')->middleware('permission:system.user.permission');
    });
});

//角色管理
Route::group(['middleware' => 'permission:system.role'], function () {
    Route::get('role','Admin\User\RoleController@index')->name('admin.role');
    Route::get('role/data','Admin\User\RoleController@data')->name('admin.role.data');
    //创建角色
    Route::get('role/create','Admin\User\RoleController@create')->name('admin.role.create')->middleware('permission:system.role.create');
    Route::post('role/store','Admin\User\RoleController@store')->name('admin.role.store')->middleware('permission:system.role.create');
    //删除角色
    Route::delete('role/destroy','Admin\User\RoleController@destroy')->name('admin.role.destroy')->middleware('permission:system.role.destroy');
    //编辑角色
    Route::get('role/{id}/edit','Admin\User\RoleController@edit')->name('admin.role.edit')->middleware('permission:system.role.edit');
    Route::put('role/{id}/update','Admin\User\RoleController@update')->name('admin.role.update')->middleware('permission:system.role.edit');
    //权限
    Route::get('role/{id}/permission','Admin\User\RoleController@permission')->name('admin.role.permission')->middleware('permission:system.role.permission');
    Route::put('role/{id}/assignPermission','Admin\User\RoleController@assignPermission')->name('admin.role.assignPermission')->middleware('permission:system.role.permission');
});

//站点设置
Route::group(['middleware' => 'permission:system.website_seo'],function () {
    Route::get('website_seo','Admin\SystemConfigController@index')->name('admin.website_seo');
    Route::get('website_seo/data','Admin\SystemConfigController@data')->name('admin.website_seo.data');
    //新增
    Route::get('website_seo/create','Admin\SystemConfigController@create')->name('admin.website_seo.create')->middleware('permission:system.website_seo.create');
    Route::post('website_seo/store','Admin\SystemConfigController@store')->name('admin.website_seo.store')->middleware('permission:system.website_seo.create');
    //编辑
    Route::get('website_seo/{id}/edit','Admin\SystemConfigController@edit')->name('admin.website_seo.edit')->middleware('permission:system.website_seo.edit');
    Route::put('website_seo/{id}/update','Admin\SystemConfigController@update')->name('admin.website_seo.update')->middleware('permission:system.website_seo.edit');
    //删除
    Route::delete('website_seo/destroy','Admin\SystemConfigController@destroy')->name('admin.website_seo.destroy')->middleware('permission:system.website_seo.destroy');
});

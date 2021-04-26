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
    Route::get('role','Admin/RoleController@index')->name('admin.role');
});

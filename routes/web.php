<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/admin');
Route::get('admin/bulk_order/list/{item?}', 'Admin\BulkOrderController@getList')->name('admin.bulk_order.data');
Route::post('video_upload', 'Admin\ProductController@video_upload')->name('admin.product.video');

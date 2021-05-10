<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['prefix' => 'user'], function () {
    Route::post('register','User\RegisterController@create')->name('users.register');
    Route::post('login','User\LoginController@Login')->name('users.login');

    Route::group(['middleware' => 'token'], function () {
        Route::get('denglu/{id}/{token}','User\LoginController@denglu')->name('user.denglu');
    });
});

Route::group(['namespace' => 'Api'], function () {
    Route::get('about-us','AboutUsController@getAboutUsInfo')->name('about-us.info');
    Route::post('contact-us','ContactUsController@contact')->name('contact-us.upload');
    Route::get('categories','MenuCategoryController@getCategories')->name('category.get');
    Route::get('footer-links','FooterLinksController@getLinks')->name('footer.links');
    Route::group(['prefix' => 'website'], function () {
        Route::get('getseo','WebsiteController@getSeo')->name('website.seo');
    });

    Route::get('blog-list','BlogController@getList')->name('blog.list');
    Route::get('blog/{id}','BlogController@getDetail')->name('blog.detail');
    Route::get('blog/category-list','BlogController@getCategoryList')->name('blog.category-list');
    Route::get('category/blog-list','BlogController@getCategoriesBlog')->name('category.blog-list');

    Route::get('product/index','ProductController@index')->name('product.index');
    Route::get('product/list','ProductController@getList')->name('product.list');
    Route::get('product/info/{id}','ProductController@detail')->name('product.detail');

    Route::get('product/category','ProductCategoryController@getList')->name('product.category.menu');
    Route::get('faq/list/{productId}','FaqController@getList')->name('faq.info.list');
    Route::get('faq/info/{questionId}','FaqController@getInfo')->name('faq.info.data');

    //个人中心
    Route::get('user/{id}','UserController@getUser')->name('user.info');
    Route::post('edit/user','UserController@editUser')->name('user.edit');
});


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
//    Route::post('sendEmail','User\RegisterController@sendEmail')->name('users.sendEmail');
    Route::post('changePassword','User\RetrievePasswordController@changePassword')->name('users.changePassword');

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
    Route::get('region','UserController@getRegion')->name('user.region');

    //发送验证码邮件
    Route::post('user/sendEmail','SendEmailController@sendEmail')->name('users.sendEmail');


















    // test ceshi
    Route::get('medium/source','MediumSourceController@img_output')->name('medium.source.img_output');
    Route::get('medium/source/output_html','MediumSourceController@output_html')->name('medium.source.output_html');

    Route::get('medium/source/pdf','MediumSourceController@output_pdf')->name('medium.source.output.pdf');
    Route::get('medium/source/video','MediumSourceController@output_video')->name('medium.source.output.video');


    // 资源列表
    Route::get('medium/list/video','MediumSourceController@get_video')->name('medium.source.list.video');
    Route::get('medium/list/brochure','MediumSourceController@get_brochure')->name('medium.source.list.brochure');
    Route::get('medium/list/instruction','MediumSourceController@get_instruction')->name('medium.source.list.instruction');
    Route::get('medium/list/qcfile','MediumSourceController@get_qcfile')->name('medium.source.list.qcfile');


    //订单接口
    Route::get('order/user/{id}','OrderController@orders')->name('order.source.list');
    Route::post('order/create','OrderController@addOrder')->name('order.add');
    Route::post('order/update','OrderController@update')->name('order.update');

    //baner接口
    Route::get('banner/index/{pageName}','BannerController@getBanner')->name('banner.index');
    Route::get('banner/list','BannerController@getBannerList')->name('banner.list');

    //加入购物车
    Route::post('product/addTCoart','AddToCartController@addToCart')->name('product.addToCart');
    Route::get('product/getCart','AddToCartController@getCart')->name('product.getCart');
    Route::post('product/destory','AddToCartController@destory')->name('product.destory');

    //搜索页面
    Route::post('search','SearchController@search')->name('search.info');
});


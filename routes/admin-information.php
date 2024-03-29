<?php

use Illuminate\Support\Facades\Route;

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
| 资讯管理模块
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth', 'permission:information']], function () {
    //blog分类管理
    Route::group(['middleware' => ['permission:information.category']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            // blog分类 系列接口
            Route::get('blog/category/index', 'BlogCategoryController@index')->name('admin.blog.category');
            Route::get('blog/category/list', 'BlogCategoryController@getList')->name('admin.blog.category.data');
            Route::get('blog/category/{id}', 'BlogCategoryController@getCategory');
            //添加分类
            Route::get('blog/category/create', 'BlogCategoryController@create')->name('admin.blog.category.create')->middleware('permission:information.category.create');
            Route::post('blog/category/add', 'BlogCategoryController@addCategory')->name('admin.blog.category.create-post')->middleware('permission:information.category.create');
            //分类编辑
            Route::get('blog/category/{id}/edit', 'BlogCategoryController@edit')->name('admin.blog.category.edit')->middleware('permission:information.category.edit');
            Route::post('blog/category/{id}/update', 'BlogCategoryController@update')->name('admin.blog.category.update')->middleware('permission:information.category.edit');
            //禁用分类
            Route::delete('blog/category/disable', 'BlogCategoryController@disable')->name('admin.blog.category.disable');
        });
    });

    //blog管理
    Route::group(['middleware' => ['permission:information.article']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            // blog 系列接口
            Route::get('blog/index', 'BlogController@index')->name('admin.blog.article');
            Route::get('blog/list', 'BlogController@getList')->name('admin.blog.article.data');
            Route::get('blog/{id}', 'BlogController@getPost');
            Route::get('blog/create', 'BlogController@create')->name('admin.blog.article.create');
            Route::post('blog/create', 'BlogController@addPost')->name('admin.blog.article.create-post');
            Route::get('blog/{id}/edit', 'BlogController@edit')->name('admin.blog.article.edit');
            Route::PUT('blog/{blog}', 'BlogController@update')->name('admin.blog.article.update');

            Route::delete('blog/disable', 'BlogController@disable')->name('admin.blog.article.disable');
            //blog 关联列表
            Route::post('blog/relate/list', 'BlogController@RataleBlogList')->name('admin.blog.relate.list');

            Route::name('admin.')->group(function () {
                Route::resource('bulk_order', 'BulkOrderController')->only(['index', 'show']);
            });
        });
    });
});

//FAQ管理
Route::group(['middleware' => ['auth', 'permission:faq']], function () {
    Route::group(['middleware' => ['permission:faq.info']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('faq/index', 'FaqController@index')->name('admin.faq.info');
            Route::get('faq/list', 'FaqController@data')->name('admin.faq.info.data');
            //添加
            Route::get('faq/create', 'FaqController@create')->name('admin.faq.create')->middleware('permission:faq.info.create');
            Route::post('faq/add', 'FaqController@addQuestion')->name('admin.faq.add')->middleware('permission:faq.info.create');
            //编辑
            Route::get('faq/{id}/edit', 'FaqController@edit')->name('admin.faq.edit')->middleware('permission:faq.info.edit');
            Route::post('faq/{id}/update', 'FaqController@update')->name('admin.faq.update')->middleware('permission:faq.info.edit');
        });
    });
});

//联系我们管理
Route::group(['middleware' => ['auth', 'permission:contact']], function () {
    Route::group(['middleware' => ['permission:contact.list']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('contact/index', 'ContactUsController@index')->name('admin.contact.list');
        });
    });
});

//business solution管理
Route::group(['middleware' => ['auth', 'permission:business.solutions']], function () {
    Route::group(['middleware' => ['permission:business.solutions.list']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('business/solution/index', 'BusinessSolutionController@index')->name('admin.solution.index');
            Route::get('business/solution/data', 'BusinessSolutionController@getList')->name('admin.solution.index.data');
            Route::get('business/solution/create', 'BusinessSolutionController@create')->name('admin.solution.create')->middleware('permission:business.solution.list.create');
            Route::post('business/solution/add', 'BusinessSolutionController@add')->name('admin.solution.add')->middleware('permission:business.solution.list.create');
            Route::get('business/solution/{id}/edit', 'BusinessSolutionController@edit')->name('admin.solution.edit')->middleware('permission:business.solution.list.edit');
            Route::post('business/solution/update', 'BusinessSolutionController@update')->name('admin.solution.update')->middleware('permission:business.solution.list.edit');
            Route::delete('business/solution/destory', 'BusinessSolutionController@destory')->name('admin.solution.destory')->middleware('permission:company.profile.destory');
        });
    });
});

//company profile 管理
Route::group(['middleware' => ['auth', 'permission:company.profile']], function () {
    Route::group(['middleware' => ['permission:company.profile.list']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('company/profile/index', 'CompanyProfileController@index')->name('admin.company.profile.index');
            Route::get('company/profile/data', 'CompanyProfileController@getList')->name('admin.company.profile.data');
            Route::get('company/profile/create', 'CompanyProfileController@create')->name('admin.company.profile.create')->middleware('permission:company.profile.create');
            Route::post('company/profile/add', 'CompanyProfileController@add')->name('admin.company.profile.add')->middleware('permission:company.profile.create');
            Route::get('company/profile/{id}/edit', 'CompanyProfileController@edit')->name('admin.company.profile.edit')->middleware('permission:company.profile.edit');
            Route::post('company/profile/update', 'CompanyProfileController@update')->name('admin.company.profile.update')->middleware('permission:company.profile.edit');
            Route::delete('company/profile/destory', 'CompanyProfileController@destory')->name('admin.company.profile.destory')->middleware('permission:company.profile.destory');
        });
    });
});

//customer 管理
Route::group(['middleware' => ['auth', 'permission:customer']], function () {
    Route::group(['middleware' => ['permission:customer.list']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('customer/index', 'CustomerController@index')->name('admin.customer.index');
            Route::get('customer/data', 'CustomerController@getList')->name('admin.customer.data');
            Route::get('customer/create', 'CustomerController@create')->name('admin.customer.create')->middleware('permission:customer.create');
            Route::post('customer/add', 'CustomerController@add')->name('admin.customer.add')->middleware('permission:customer.create');
            Route::get('customer/{id}/edit', 'CustomerController@edit')->name('admin.customer.edit')->middleware('permission:customer.edit');
            Route::post('customer/update', 'CustomerController@update')->name('admin.customer.update')->middleware('permission:customer.edit');
            //            Route::delete('customer/destory','CustomerController@destory')->name('admin.customer.destory')->middleware('permission:customer.destory');
        });
    });
});

//about loctek 管理
Route::group(['middleware' => ['auth', 'permission:about.loctek']], function () {
    Route::group(['middleware' => ['permission:about.loctek.list']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('aboutLoctek/index', 'AboutLoctekController@index')->name('admin.about.loctek.index');
            Route::get('aboutLoctek/data', 'AboutLoctekController@getList')->name('admin.about.loctek.data');
            Route::get('aboutLoctek/create', 'AboutLoctekController@create')->name('admin.about.loctek.create')->middleware('permission:about.loctek.create');
            Route::post('aboutLoctek/add', 'AboutLoctekController@add')->name('admin.about.loctek.add')->middleware('permission:about.loctek.create');
            Route::get('aboutLoctek/{id}/edit', 'AboutLoctekController@edit')->name('admin.about.loctek.edit')->middleware('permission:about.loctek.edit');
            Route::post('aboutLoctek/update', 'AboutLoctekController@update')->name('admin.about.loctek.update')->middleware('permission:about.loctek.edit');
            Route::delete('aboutLoctek/destory', 'AboutLoctekController@destory')->name('admin.about.loctek.destory')->middleware('permission:about.loctek.destory');
        });
    });
});

//Site Map 管理
Route::group(['middleware' => ['auth', 'permission:siteMap']], function () {
    Route::group(['middleware' => ['permission:siteMap.list']], function () {
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('siteMap/index', 'SiteMapController@index')->name('admin.site.map.index')->middleware('permission:siteMap.list');
            Route::get('siteMap/data', 'SiteMapController@getList')->name('admin.site.map.data')->middleware('permission:siteMap.list');
            Route::get('siteMap/{id}/edit', 'SiteMapController@edit')->name('admin.site.map.edit')->middleware('permission:siteMap.edit');
            Route::post('siteMap/update', 'SiteMapController@update')->name('admin.site.map.update')->middleware('permission:siteMap.edit');
        });
    });
});

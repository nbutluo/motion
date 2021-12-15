<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Model\Blog\Blog;
use App\Observers\BlogObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blog::observe(BlogObserver::class);

        Schema::defaultStringLength(250);

        //全局分配当前登录用户
        view()->composer('*', function ($view) {
            $view->with('currentUser', auth()->user());
        });
    }
}

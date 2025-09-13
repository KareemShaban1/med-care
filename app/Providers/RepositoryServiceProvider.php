<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('App\Repository\Admin\CategoryRepositoryInterface', 'App\Repository\Admin\CategoryRepository');
        $this->app->bind('App\Repository\Admin\ProductRepositoryInterface', 'App\Repository\Admin\ProductRepository');
        $this->app->bind('App\Repository\Admin\BannerRepositoryInterface', 'App\Repository\Admin\BannerRepository');
        $this->app->bind('App\Repository\Admin\OrderRepositoryInterface', 'App\Repository\Admin\OrderRepository');
        $this->app->bind('App\Repository\Admin\ActivityLogRepositoryInterface', 'App\Repository\Admin\ActivityLogRepository');


        $this->app->bind('App\Repository\Frontend\HomeRepositoryInterface', 'App\Repository\Frontend\HomeRepository');
        $this->app->bind('App\Repository\Frontend\CartRepositoryInterface', 'App\Repository\Frontend\CartRepository');
        $this->app->bind('App\Repository\Frontend\CheckoutRepositoryInterface', 'App\Repository\Frontend\CheckoutRepository');



    }


    public function boot()
    {
        //
    }
}

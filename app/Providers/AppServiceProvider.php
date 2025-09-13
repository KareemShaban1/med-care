<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\GenericObserver;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Observers\ProductObserver;
use App\Observers\OrderObserver;
use App\Observers\CategoryObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $models = [
            'App\Models\Banner',
            'App\Models\Category',
            'App\Models\Product',
            'App\Models\Order',
        ];
        foreach ($models as $model) {
            $model::observe(GenericObserver::class);
        }

        Product::observe(ProductObserver::class);
        Order::observe(OrderObserver::class);
        Category::observe(CategoryObserver::class);
        
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Observers\CategoryObserver;
use App\Models\Product;
use App\Observers\GenericObserver;
use App\Observers\ProductObserver;

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
    }
}

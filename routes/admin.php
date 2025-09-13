<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BannerController as AdminBanner;
use App\Http\Controllers\Backend\CategoryController as AdminCategory;
use App\Http\Controllers\Backend\ProductController as AdminProduct;
use App\Http\Controllers\Backend\OrderController as AdminOrder;
use App\Http\Controllers\Backend\ActivityLogController as ActivityLogController;

Route::group([
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'as' => 'admin.',
    'middleware' => [
        'auth',
        'localeCookieRedirect',
        'localizationRedirect',
        'localeViewPath'
    ]
], function () {
    Route::get('/', function () {
        return redirect()->route('products.index');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('banners/data', [AdminBanner::class, 'data'])->name('banners.data');
    Route::post('banners/update-status', [AdminBanner::class, 'updateStatus'])->name('banners.update-status');
    Route::get('banners/trash', [AdminBanner::class, 'trash'])->name('banners.trash');
    Route::get('banners/trash/data', [AdminBanner::class, 'trashData'])->name('banners.trash.data');
    Route::post('banners/{id}/restore', [AdminBanner::class, 'restore'])->name('banners.restore');
    Route::delete('banners/{id}/force-delete', [AdminBanner::class, 'forceDelete'])->name('banners.forceDelete');
    Route::resource('banners', AdminBanner::class);


    Route::get('categories/data', [AdminCategory::class, 'data'])->name('categories.data');
    Route::post('categories/update-status', [AdminCategory::class, 'updateStatus'])->name('categories.update-status');
    Route::get('categories/trash', [AdminCategory::class, 'trash'])->name('categories.trash');
    Route::get('categories/trash/data', [AdminCategory::class, 'trashData'])->name('categories.trash.data');
    Route::post('categories/{id}/restore', [AdminCategory::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{id}/force-delete', [AdminCategory::class, 'forceDelete'])->name('categories.forceDelete');
    Route::resource('categories', AdminCategory::class);

    Route::get('products/data', [AdminProduct::class, 'data'])->name('products.data');
    Route::get('products/trash', [AdminProduct::class, 'trash'])->name('products.trash');
    Route::get('products/trash/data', [AdminProduct::class, 'trashData'])->name('products.trash.data');
    Route::post('products/{id}/restore', [AdminProduct::class, 'restore'])->name('products.restore');
    Route::delete('products/{id}/force-delete', [AdminProduct::class, 'forceDelete'])->name('products.forceDelete');
    Route::resource('products', AdminProduct::class);


    Route::get('orders/data', [AdminOrder::class, 'data'])->name('orders.data');
    Route::resource('orders', AdminOrder::class);
    Route::post('orders/{order}/status', [AdminOrder::class, 'changeStatus'])->name('orders.changeStatus');

    Route::get('activity-logs/data', [ActivityLogController::class, 'data'])->name('activity-logs.data');
    Route::resource('activity-logs', ActivityLogController::class);
});

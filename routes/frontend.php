<?php
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeCookieRedirect',
        'localizationRedirect',
        'localeViewPath'
    ]
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/product/{slug}', [HomeController::class, 'showProduct'])->name('product.show');
    Route::get('/products', [HomeController::class, 'getAllProducts'])->name('products');
    Route::get('/policy', [HomeController::class, 'policy'])->name('policy');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order/confirmation/{uuid}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');
});

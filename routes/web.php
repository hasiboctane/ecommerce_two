<?php

use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\PasswordResetPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\CancelPage;
use App\Livewire\CartPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\MyOrdersPage;
use App\Livewire\OrderDetailsPage;
use App\Livewire\ProductDetailsPage;
use App\Livewire\ProductsPage;
use App\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;

Route::get('/',HomePage::class)->name('home');
Route::get('/categories', CategoriesPage::class)->name('categories');
// Route::get('/products', ProductsPage::class)->name('products');
// Route::get('/products/{parent_category?}', ProductsPage::class)->name('products');
Route::get('/products/{parent_category?}/{category?}', ProductsPage::class)->name('products');
Route::get('/cart', CartPage::class)->name('cart');
Route::get('/products/{parent_category?}/{category?}/{slug}', ProductDetailsPage::class)->name('product.show');


Route::middleware('guest')->group(function () {
    Route::get('/register', RegisterPage::class)->name('register');
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/forgot-password', ForgotPasswordPage::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPasswordPage::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', CheckoutPage::class)->name('checkout');
    Route::get('/my-orders', MyOrdersPage::class)->name('my-orders');
    Route::get('/my-orders/{order_id}', OrderDetailsPage::class)->name('my-orders.show');
    Route::get('/success', SuccessPage::class)->name('success');
    Route::get('/cancel',CancelPage::class)->name('cancel');
    Route::get('/logout', function () {
        auth()->guard()->logout();
        return redirect()->route('home');
    })->name('logout');
});


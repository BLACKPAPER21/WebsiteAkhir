<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Need Auth Routes
Route::middleware(['auth'])->group(function () {
    // User Dashboard
    Route::get('/dashboard', [OrderController::class, 'index'])->name('dashboard');
    
    // Profile (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout & Orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/success', [OrderController::class, 'success'])->name('orders.success');

    // Wishlist
    Route::get('/wishlists', [WishlistController::class, 'index'])->name('wishlists.index');
    Route::post('/wishlists/{product}/toggle', [WishlistController::class, 'toggle'])->name('wishlists.toggle');
    // Partner Registration
    Route::get('/partner', [App\Http\Controllers\PartnerController::class, 'index'])->name('partner.index');
    Route::get('/partner/register', [App\Http\Controllers\PartnerController::class, 'create'])->name('partner.register');
    Route::post('/partner/register', [App\Http\Controllers\PartnerController::class, 'store'])->name('partner.store');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('products', AdminProductController::class);
    
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Partners Management
    Route::get('/partners', [App\Http\Controllers\Admin\PartnerController::class, 'index'])->name('partners.index');
    Route::patch('/partners/{application}/approve', [App\Http\Controllers\Admin\PartnerController::class, 'approve'])->name('partners.approve');
    Route::patch('/partners/{application}/reject', [App\Http\Controllers\Admin\PartnerController::class, 'reject'])->name('partners.reject');
});

require __DIR__.'/auth.php';

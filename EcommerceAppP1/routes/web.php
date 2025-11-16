<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public "Welcome" route
Route::get('/', function () {
    return view('welcome');
});

// Public "Shop" route
Route::get('/shop', [ProductController::class, 'shop'])->name('shop.index');

// Default Dashboard (for authenticated & verified users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// === AUTHENTICATED USER ROUTES ===
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Product & Category Routes (for regular users)
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    // Cart Routes
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/remove/{rowId}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Regular User Dashboard (Breeze default)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// === ADMIN ROUTES ===
// Uses the 'admin' middleware (CheckIsAdmin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Product Management
    Route::resource('products', ProductController::class);

    // Category Management
    Route::resource('categories', CategoryController::class);

    // Order Management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.updateStatus');

    // Extra admin route (if you want /admin/dashboard to also load index)
    Route::get('/dashboard-alt', [AdminController::class, 'index'])->name('dashboard.alt');
});

// Authentication routes (Breeze/Fortify)
require __DIR__.'/auth.php';

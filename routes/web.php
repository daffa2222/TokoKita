<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
// Import Controller Baru (Pastikan file ini dibuat nanti)
use App\Http\Controllers\StoreProfileController; 

/*
|--------------------------------------------------------------------------
| Web Routes (Jalur Web TokoKita)
|--------------------------------------------------------------------------
*/

// ====================================================
// 1. HALAMAN PUBLIK (Bisa diakses siapa saja)
// ====================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [HomeController::class, 'show'])->name('product.detail');

// RUTE BARU: Profil Toko Publik (Agar nama toko bisa diklik)
Route::get('/toko/{slug}', [StoreProfileController::class, 'show'])->name('store.show');


// Route Dashboard Bawaan
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    if ($user->role === 'seller') return redirect()->route('seller.dashboard');
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');


// ====================================================
// 2. HALAMAN KHUSUS ADMIN
// ====================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class); // CRUD User Lengkap
    
    Route::get('/verify-sellers', [AdminController::class, 'pendingSellers'])->name('verify.sellers');
    Route::patch('/verify-sellers/{id}/approve', [AdminController::class, 'approveSeller'])->name('approve.seller');
    Route::patch('/verify-sellers/{id}/reject', [AdminController::class, 'rejectSeller'])->name('reject.seller');

    Route::resource('categories', CategoryController::class)->except(['create', 'show']);

    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
});


// ====================================================
// 3. HALAMAN KHUSUS SELLER
// ====================================================
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/pending', function () { return view('seller.pending'); })->name('pending');
    
    Route::middleware(['seller.approved'])->group(function() {
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
        Route::get('/store/edit', [SellerController::class, 'editStore'])->name('store.edit');
        Route::put('/store/update', [SellerController::class, 'updateStore'])->name('store.update');
        Route::resource('products', ProductController::class);
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{id}/update', [SellerOrderController::class, 'updateStatus'])->name('orders.update');
    });
});


// ====================================================
// 4. HALAMAN KHUSUS BUYER
// ====================================================
Route::middleware(['auth', 'role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.delete');
    Route::patch('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::post('/review/{productId}', [ReviewController::class, 'store'])->name('review.store');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});


// Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
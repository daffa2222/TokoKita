<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes (Jalur Web TokoKita)
|--------------------------------------------------------------------------
*/

// 1. HALAMAN PUBLIK (Bisa diakses siapa saja)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [HomeController::class, 'show'])->name('product.detail');

// Route Bawaan Dashboard (Kita redirect sesuai role nanti)
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    if ($user->role === 'seller') return redirect()->route('seller.dashboard');
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// 2. HALAMAN KHUSUS ADMIN (Wajib Login & Role Admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    
    // Verifikasi Seller
    Route::get('/verify-sellers', [AdminController::class, 'pendingSellers'])->name('verify.sellers');
    Route::patch('/verify-sellers/{id}/approve', [AdminController::class, 'approveSeller'])->name('approve.seller');
    Route::patch('/verify-sellers/{id}/reject', [AdminController::class, 'rejectSeller'])->name('reject.seller');
    
    // Hapus User
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Manajemen Kategori
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
});

// 3. HALAMAN KHUSUS SELLER (Wajib Login & Role Seller)
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    
    // Halaman Pending (Bisa diakses walau belum disetujui)
    Route::get('/pending', function () {
        return view('seller.pending'); 
    })->name('pending');
    
    // Grup Khusus Seller yang SUDAH DISETUJUI (Approved)
    Route::middleware(['seller.approved'])->group(function() {
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
        
        // Manajemen Toko
        Route::get('/store/edit', [SellerController::class, 'editStore'])->name('store.edit');
        Route::put('/store/update', [SellerController::class, 'updateStore'])->name('store.update');
        
        // Manajemen Produk
        Route::resource('products', ProductController::class);
        
        // Pesanan Masuk
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    });
});

// 4. HALAMAN KHUSUS BUYER (Wajib Login & Role Buyer)
Route::middleware(['auth', 'role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    // Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.delete');
    
    // Checkout & Pesanan
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    
    // Review Produk
    Route::post('/review/{productId}', [ReviewController::class, 'store'])->name('review.store');
});

// Route Bawaan Breeze (Profile, Logout, dll)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
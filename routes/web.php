<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
// PENTING: Import Controller Admin User yang benar (namespace terpisah)
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;

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

// Route Dashboard Bawaan (Redirect otomatis sesuai role)
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    if ($user->role === 'seller') return redirect()->route('seller.dashboard');
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');


// ====================================================
// 2. HALAMAN KHUSUS ADMIN (Wajib Login & Role Admin)
// ====================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Manajemen User (Menggunakan UserController terpisah di folder Admin)
    // Resource ini mencakup: index, create, store, edit, update, destroy
    Route::resource('users', UserController::class);
    
    // Verifikasi Seller
    Route::get('/verify-sellers', [AdminController::class, 'pendingSellers'])->name('verify.sellers');
    Route::patch('/verify-sellers/{id}/approve', [AdminController::class, 'approveSeller'])->name('approve.seller');
    Route::patch('/verify-sellers/{id}/reject', [AdminController::class, 'rejectSeller'])->name('reject.seller');

    // Manajemen Kategori (CRUD)
    // Kita gunakan resource standar, kecuali create & show jika tidak diperlukan
    Route::resource('categories', CategoryController::class)->except(['create', 'show']);

    // Manajemen Produk (Admin Hapus Produk)
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
});


// ====================================================
// 3. HALAMAN KHUSUS SELLER (Wajib Login & Role Seller)
// ====================================================
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    
    // Halaman Pending (Bisa diakses walau belum disetujui)
    Route::get('/pending', function () {
        return view('seller.pending'); 
    })->name('pending');
    
    // Grup Khusus Seller yang SUDAH DISETUJUI (Approved)
    Route::middleware(['seller.approved'])->group(function() {
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
        
        // Manajemen Toko (Edit Info & Foto)
        Route::get('/store/edit', [SellerController::class, 'editStore'])->name('store.edit');
        Route::put('/store/update', [SellerController::class, 'updateStore'])->name('store.update');
        
        // Manajemen Produk (CRUD)
        Route::resource('products', ProductController::class);
        
        // Pesanan Masuk & Update Status
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{id}/update', [SellerOrderController::class, 'updateStatus'])->name('orders.update');
    });
});


// ====================================================
// 4. HALAMAN KHUSUS BUYER (Wajib Login & Role Buyer)
// ====================================================
Route::middleware(['auth', 'role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    
    // Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.delete');
    // Update Jumlah (+/-)
    Route::patch('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    
    // Checkout & Pesanan
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    
    // Review Produk
    Route::post('/review/{productId}', [ReviewController::class, 'store'])->name('review.store');

    // Wishlist (Favorit)
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});


// Route Bawaan Breeze (Profile, Logout, dll)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
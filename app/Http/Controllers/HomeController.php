<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Depan (Homepage)
     * Mengelola daftar produk, pencarian, filter kategori, dan sorting harga.
     */
    public function index(Request $request)
    {
        // 1. Siapkan query dasar dengan relasi (Eager Loading) agar performa cepat
        $query = Product::with(['category', 'store']);

        // -----------------------------------------------------------
        // LOGIKA 1: PENCARIAN (SEARCH)
        // -----------------------------------------------------------
        if ($request->has('search') && $request->search != null) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // -----------------------------------------------------------
        // LOGIKA 2: FILTER KATEGORI
        // -----------------------------------------------------------
        if ($request->has('category') && $request->category != null) {
            $query->where('category_id', $request->category);
        }

        // -----------------------------------------------------------
        // LOGIKA 3: SORTING / PENGURUTAN (FITUR BARU)
        // -----------------------------------------------------------
        if ($request->has('sort')) {
            if ($request->sort == 'low_high') {
                // Urutkan dari Harga Terendah ke Tertinggi (ASC)
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'high_low') {
                // Urutkan dari Harga Tertinggi ke Terendah (DESC)
                $query->orderBy('price', 'desc');
            } else {
                // Default: Produk Terbaru
                $query->latest();
            }
        } else {
            // Jika tidak ada request sort, default tampilkan terbaru
            $query->latest();
        }

        // -----------------------------------------------------------
        // EKSEKUSI DATA
        // -----------------------------------------------------------
        
        // Ambil data produk dengan pagination (12 per halaman)
        // method appends($request->all()) berguna agar saat pindah halaman, filter search/sort tidak hilang
        $products = $query->paginate(12)->appends($request->all());
        
        // Ambil semua kategori untuk dropdown filter di tampilan
        $categories = Category::all();

        // Kirim data ke view 'home'
        return view('home', compact('products', 'categories'));
    }

    /**
     * Menampilkan Halaman Detail Produk
     */
    public function show($slug)
    {
        // Cari produk berdasarkan slug
        $product = Product::with(['store', 'reviews.user', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Hitung rata-rata rating
        $rating = $product->reviews()->avg('rating');

        return view('product-detail', compact('product', 'rating'));
    }
}
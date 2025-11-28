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
        // LOGIKA 3: SORTING / PENGURUTAN
        // -----------------------------------------------------------
        if ($request->has('sort')) {
            if ($request->sort == 'low_high') {
                $query->orderBy('price', 'asc'); // Termurah
            } elseif ($request->sort == 'high_low') {
                $query->orderBy('price', 'desc'); // Termahal
            } else {
                $query->latest(); // Default Terbaru
            }
        } else {
            $query->latest();
        }

        // -----------------------------------------------------------
        // EKSEKUSI DATA (PERBAIKAN DISINI)
        // -----------------------------------------------------------
        
        // Batas per halaman diubah dari 12 menjadi 15 sesuai permintaan
        $products = $query->paginate(15)->appends($request->all());
        
        // Ambil semua kategori untuk dropdown filter
        $categories = Category::all();

        return view('home', compact('products', 'categories'));
    }

    /**
     * Menampilkan Halaman Detail Produk
     */
    public function show($slug)
    {
        $product = Product::with(['store', 'reviews.user', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        $rating = $product->reviews()->avg('rating');

        return view('product-detail', compact('product', 'rating'));
    }
}
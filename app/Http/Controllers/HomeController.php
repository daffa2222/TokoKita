<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Depan (Homepage)
     * Berisi daftar produk terbaru, fitur pencarian, dan filter kategori.
     */
    public function index(Request $request)
    {
        // 1. Siapkan query produk dengan relasi ke kategori dan toko
        // Kita gunakan 'with' agar database tidak dipanggil berulang-ulang (Eager Loading)
        $query = Product::with(['category', 'store']);

        // 2. Logika Pencarian: Jika ada input 'search' dari pengguna
        if ($request->has('search') && $request->search != null) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. Logika Filter Kategori: Jika pengguna memilih kategori tertentu
        if ($request->has('category') && $request->category != null) {
            $query->where('category_id', $request->category);
        }

        // 4. Ambil data produk (12 produk per halaman agar rapi)
        // latest() artinya mengurutkan dari yang paling baru dibuat
        $products = $query->latest()->paginate(12);
        
        // 5. Ambil semua data kategori untuk ditampilkan di dropdown filter halaman depan
        $categories = Category::all();

        // Kirim data produk dan kategori ke view 'home'
        return view('home', compact('products', 'categories'));
    }

    /**
     * Menampilkan Halaman Detail Produk
     * Dijalankan saat user mengklik salah satu produk.
     */
    public function show($slug)
    {
        // Cari produk berdasarkan 'slug' (URL ramah pengguna)
        // Kita juga ambil data Toko, Review beserta User yg mereview, dan Kategori-nya
        $product = Product::with(['store', 'reviews.user', 'category'])
            ->where('slug', $slug)
            ->firstOrFail(); // Jika tidak ketemu, otomatis tampilkan error 404

        // Hitung rata-rata rating bintang dari review yang ada (contoh: 4.5)
        $rating = $product->reviews()->avg('rating');

        // Kirim data ke view 'product-detail'
        return view('product-detail', compact('product', 'rating'));
    }
}
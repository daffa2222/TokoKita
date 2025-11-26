<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Menampilkan Daftar Wishlist Saya
     * Halaman ini hanya bisa diakses oleh Buyer yang sudah login.
     */
    public function index()
    {
        // Ambil data wishlist milik user yang sedang login
        // Kita gunakan 'with' untuk mengambil data produk & kategorinya sekalian (Eager Loading)
        // Supaya hemat query database
        $wishlists = Wishlist::where('user_id', Auth::id())
                        ->with('product.category') 
                        ->latest() // Urutkan dari yang paling baru dilike
                        ->get();

        return view('buyer.wishlist', compact('wishlists'));
    }

    /**
     * Toggle Wishlist (Tambah/Hapus)
     * Fungsi ini dipanggil saat tombol "Hati/Love" diklik.
     */
    public function toggle($productId)
    {
        $user = Auth::user();
        
        // Cek apakah produk ini sudah ada di wishlist user tersebut?
        $existingWishlist = Wishlist::where('user_id', $user->id)
                                    ->where('product_id', $productId)
                                    ->first();

        if ($existingWishlist) {
            // KONDISI 1: SUDAH ADA -> HAPUS (UNLIKE)
            $existingWishlist->delete();
            
            return back()->with('success', 'Produk dihapus dari daftar favorit.');
        } else {
            // KONDISI 2: BELUM ADA -> TAMBAH (LIKE)
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);
            
            return back()->with('success', 'Produk berhasil ditambahkan ke favorit! ❤');
        }
    }
}
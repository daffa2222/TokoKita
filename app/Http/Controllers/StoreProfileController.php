<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreProfileController extends Controller
{
    // Menampilkan Profil Toko untuk Umum
    public function show($slug)
    {
        // Cari toko berdasarkan slug
        $store = Store::where('slug', $slug)->firstOrFail();

        // Ambil produk-produk dari toko ini saja
        $products = Product::where('store_id', $store->id)
            ->with('category')
            ->latest()
            ->paginate(12);

        return view('store-profile', compact('store', 'products'));
    }
}
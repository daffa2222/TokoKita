<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\OrderItem;

class SellerController extends Controller
{
    // Dashboard Utama Seller
    public function dashboard()
    {
        $store = auth()->user()->store;
        
        // Jika belum punya toko (antisipasi error)
        if(!$store) {
             return redirect()->route('home')->with('error', 'Toko tidak ditemukan.');
        }

        // 1. Total Produk
        $totalProducts = Product::where('store_id', $store->id)->count();
        
        // 2. Total Pesanan Masuk (Cek tabel order_items milik toko ini)
        $totalOrders = OrderItem::where('store_id', $store->id)->count();

        // 3. Total Pendapatan
        $revenue = OrderItem::where('store_id', $store->id)
            ->get()
            ->sum(function($item) {
                return $item->price * $item->quantity;
            });

        return view('seller.dashboard', compact('totalProducts', 'totalOrders', 'revenue'));
    }

    // Halaman Edit Toko
    public function editStore()
    {
        $store = auth()->user()->store;
        return view('seller.store.edit', compact('store'));
    }

    // Proses Update Informasi Toko
    public function updateStore(Request $request)
    {
        $store = auth()->user()->store;

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ];

        // Logika Upload Gambar Toko
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($store->image) {
                Storage::delete('public/' . $store->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('stores', 'public');
        }

        $store->update($data);

        return redirect()->route('seller.dashboard')->with('success', 'Informasi toko berhasil diperbarui!');
    }
}
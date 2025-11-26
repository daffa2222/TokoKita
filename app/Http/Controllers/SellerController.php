<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\OrderItem;

class SellerController extends Controller
{
    public function dashboard()
    {
        $store = auth()->user()->store;
        
        if(!$store) {
             return redirect()->route('home')->with('error', 'Toko tidak ditemukan.');
        }

        // 1. Total Produk
        $totalProducts = Product::where('store_id', $store->id)->count();
        
        // 2. Pesanan Masuk (YANG BELUM SELESAI)
        // Kita hitung hanya yang statusnya 'pending', 'paid', atau 'processing'
        $totalOrders = OrderItem::where('store_id', $store->id)
            ->whereHas('order', function($q) {
                $q->whereIn('status', ['pending', 'paid', 'processing', 'shipped']);
            })->count();

        // 3. Total Pendapatan (Hanya dari pesanan SELESAI)
        $revenue = OrderItem::where('store_id', $store->id)
            ->whereHas('order', function($q) {
                $q->where('status', 'completed');
            })
            ->get()
            ->sum(function($item) {
                return $item->price * $item->quantity;
            });

        return view('seller.dashboard', compact('totalProducts', 'totalOrders', 'revenue'));
    }

    // ... method editStore dan updateStore tetap sama ...
    public function editStore()
    {
        $store = auth()->user()->store;
        return view('seller.store.edit', compact('store'));
    }

    public function updateStore(Request $request)
    {
        $store = auth()->user()->store;

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($store->image) {
                Storage::delete('public/' . $store->image);
            }
            $data['image'] = $request->file('image')->store('stores', 'public');
        }

        $store->update($data);

        return redirect()->route('seller.dashboard')->with('success', 'Informasi toko berhasil diperbarui!');
    }
}
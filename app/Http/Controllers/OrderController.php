<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // Proses Checkout (Transaksi)
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->with('product')->get();

        // 1. Validasi Keranjang
        if($carts->isEmpty()) {
            return back()->with('error', 'Keranjang belanja Anda kosong.');
        }

        // 2. Validasi Alamat
        // Gunakan input alamat dari form checkout, atau fallback ke alamat profil user
        $address = $request->address ?? $user->address;
        
        if(!$address) {
            return back()->with('error', 'Mohon isi alamat pengiriman di profil atau saat checkout.');
        }

        // MULAI TRANSAKSI DATABASE
        DB::beginTransaction();
        try {
            $totalPrice = $carts->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            // A. Buat Data Order Utama
            $order = Order::create([
                'user_id' => $user->id,
                'invoice_code' => 'INV-' . Str::upper(Str::random(10)),
                'status' => 'pending',
                'total_price' => $totalPrice,
                'delivery_address' => $address
            ]);

            // B. Pindahkan Item Keranjang ke Order Items
            foreach($carts as $cart) {
                // Cek stok terakhir sebelum deal
                if($cart->product->stock < $cart->quantity) {
                    throw new \Exception("Stok produk " . $cart->product->name . " tidak mencukupi.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'store_id' => $cart->product->store_id, // Penting untuk Seller
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price
                ]);

                // Kurangi Stok Produk
                $cart->product->decrement('stock', $cart->quantity);
            }

            // C. Kosongkan Keranjang
            Cart::where('user_id', $user->id)->delete();

            // Simpan Permanen
            DB::commit();
            
            return redirect()->route('buyer.orders')->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            // Batalkan jika ada error
            DB::rollback();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    // Riwayat Pesanan Saya
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                    ->latest()
                    ->with('items.product') // Load detail barangnya
                    ->get();

        return view('buyer.orders.index', compact('orders'));
    }
}
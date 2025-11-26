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
    // Proses Checkout (Hanya Barang yang Dicentang)
    public function checkout(Request $request)
    {
        $user = Auth::user();
        
        // 1. Ambil ID barang yang dicentang dari form (array)
        $selectedItems = $request->input('selected_items');

        // Validasi: Harus ada minimal 1 barang yang dipilih
        if (!$selectedItems || count($selectedItems) == 0) {
            return back()->with('error', 'Silakan pilih (centang) minimal satu barang untuk dicheckout.');
        }

        // 2. Ambil Data Keranjang berdasarkan ID yang dipilih saja
        $carts = Cart::where('user_id', $user->id)
                     ->whereIn('id', $selectedItems) // Filter HANYA yang dicentang
                     ->with('product')
                     ->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Item yang dipilih tidak valid.');
        }

        // 3. Validasi Alamat (Prioritas: Input Form > Data Profil)
        $address = $request->address ?? $user->address;
        
        if (!$address) {
            return back()->with('error', 'Mohon isi alamat pengiriman.');
        }

        // MULAI TRANSAKSI DATABASE
        DB::beginTransaction();
        try {
            // Hitung Total Harga (Hanya item yang dipilih)
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

            // B. Pindahkan Item ke OrderItems
            foreach ($carts as $cart) {
                // Cek stok terakhir sebelum deal
                if ($cart->product->stock < $cart->quantity) {
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
                
                // Hapus item dari keranjang (HANYA yang sudah dicheckout)
                $cart->delete();
            }

            // Update alamat di profil user (agar besok tidak perlu ngetik lagi)
            $user->update(['address' => $address]);

            // Simpan Permanen
            DB::commit();
            
            return redirect()->route('buyer.orders')->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            // Batalkan semua jika ada error
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
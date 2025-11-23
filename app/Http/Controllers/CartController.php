<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Lihat Keranjang
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->with('product')->get();
        
        // Hitung Total Belanja
        $total = $carts->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('buyer.cart', compact('carts', 'total'));
    }

    // Tambah ke Keranjang
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        // Cek Stok
        if($product->stock < 1) {
            return back()->with('error', 'Maaf, stok produk ini habis!');
        }

        // Cek apakah produk sudah ada di cart user ini
        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

        if($cart) {
            // Jika ada, tambah qty
            $cart->increment('quantity');
        } else {
            // Jika belum, buat baru
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        return redirect()->route('buyer.cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Hapus dari Keranjang
    public function destroy($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
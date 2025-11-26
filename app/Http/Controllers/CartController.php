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
        
        $total = $carts->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('buyer.cart', compact('carts', 'total'));
    }

    // Tambah ke Keranjang
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        if($product->stock < 1) {
            return back()->with('error', 'Maaf, stok produk ini habis!');
        }

        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

        if($cart) {
            // Cek apakah stok masih cukup jika ditambah
            if($cart->quantity + 1 <= $product->stock) {
                $cart->increment('quantity');
            } else {
                return back()->with('error', 'Stok produk tidak mencukupi!');
            }
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        return redirect()->route('buyer.cart')->with('success', 'Produk berhasil masuk keranjang!');
    }

    // LOGIKA BARU: Update Jumlah (+ dan -)
    public function updateQuantity(Request $request, $id)
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);
        $action = $request->input('action'); // 'increase' atau 'decrease'

        if ($action === 'increase') {
            // Cek stok sebelum nambah
            if ($cart->quantity < $cart->product->stock) {
                $cart->increment('quantity');
            } else {
                return back()->with('error', 'Stok maksimal tercapai!');
            }
        } elseif ($action === 'decrease') {
            // Cek supaya tidak minus
            if ($cart->quantity > 1) {
                $cart->decrement('quantity');
            } else {
                // Jika sisa 1 dan dikurangi, apakah mau dihapus?
                // Untuk sekarang kita biarkan minimal 1.
                return back()->with('error', 'Minimal pembelian 1 unit.');
            }
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    // Hapus dari Keranjang
    public function destroy($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
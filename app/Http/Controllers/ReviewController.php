<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Proses Menyimpan Review Baru
     * User hanya boleh review jika sudah beli barangnya dan status order 'completed'.
     */
    public function store(Request $request, $productId)
    {
        // 1. Validasi Input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5', // Bintang 1 sampai 5
            'comment' => 'nullable|string|max:500',     // Komentar maksimal 500 karakter
        ]);

        $user = Auth::user();

        // 2. CEK SYARAT: Apakah user pernah membeli produk ini DAN statusnya 'completed'?
        // Kita cari di tabel Order milik user, yang statusnya 'completed',
        // dan di dalamnya ada item dengan product_id yang dimaksud.
        $hasPurchased = Order::where('user_id', $user->id)
            ->where('status', 'completed') // Syarat Wajib: Order harus selesai
            ->whereHas('items', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })->exists();

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'Maaf, Anda hanya bisa memberi ulasan pada produk yang sudah dibeli dan pesanan telah selesai.');
        }

        // 3. CEK DUPLIKASI: Apakah user sudah pernah review produk ini sebelumnya?
        $existingReview = Review::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini sebelumnya.');
        }

        // 4. Simpan Review ke Database
        Review::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda berhasil diterbitkan.');
    }

    /**
     * Menghapus Review (Opsional)
     * Jika user ingin membatalkan reviewnya.
     */
    public function destroy($id)
    {
        $review = Review::where('user_id', Auth::id())->findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
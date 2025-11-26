<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Dashboard Admin
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $pendingSellers = User::where('role', 'seller')->where('seller_status', 'pending')->count();

        return view('admin.dashboard', compact('totalUsers', 'totalProducts', 'totalOrders', 'pendingSellers'));
    }

    // Verifikasi Seller (Halaman Tabel)
    // Verifikasi Seller (Tampilkan SEMUA Seller untuk dipantau statusnya)
    public function pendingSellers()
    {
        // Ambil semua user dengan role 'seller', urutkan dari yang terbaru
        // Agar yang baru daftar (pending) muncul paling atas
        $sellers = User::where('role', 'seller')
            ->with('store')
            ->latest()
            ->get();

        return view('admin.verify-seller', compact('sellers'));
    }

    // Aksi Approve Seller
    public function approveSeller($id)
    {
        $seller = User::findOrFail($id);
        $seller->update(['seller_status' => 'approved']);
        return redirect()->back()->with('success', 'Akun Seller berhasil disetujui!');
    }

    // Aksi Reject Seller
    public function rejectSeller($id)
    {
        $seller = User::findOrFail($id);
        $seller->update(['seller_status' => 'rejected']);
        return redirect()->back()->with('success', 'Akun Seller telah ditolak.');
    }

    // --- FITUR MANAJEMEN PRODUK (ADMIN) ---

    // 1. Lihat Semua Produk
    public function products()
    {
        // Ambil semua produk dari semua seller dengan pagination
        $products = Product::with(['store', 'category'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // 2. Hapus Produk Paksa (Jika melanggar aturan)
    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        
        // Hapus gambar dari penyimpanan jika ada
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus oleh Admin (Pelanggaran Ketentuan).');
    }
}
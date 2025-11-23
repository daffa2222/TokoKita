<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard Utama Admin
     * Menampilkan statistik ringkas.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        
        // Hitung berapa seller yang masih status 'pending' (butuh verifikasi)
        $pendingSellers = User::where('role', 'seller')
                              ->where('seller_status', 'pending')
                              ->count();

        return view('admin.dashboard', compact('totalUsers', 'totalProducts', 'totalOrders', 'pendingSellers'));
    }

    /**
     * Halaman Verifikasi Seller
     * Hanya menampilkan seller yang statusnya 'pending'.
     */
    public function pendingSellers()
    {
        $sellers = User::where('role', 'seller')
            ->where('seller_status', 'pending')
            ->with('store') // Load data tokonya juga
            ->get();

        return view('admin.verify-seller', compact('sellers'));
    }

    /**
     * Proses Menyetujui (Approve) Seller
     */
    public function approveSeller($id)
    {
        $seller = User::findOrFail($id);
        $seller->update(['seller_status' => 'approved']);

        return redirect()->back()->with('success', 'Akun Seller berhasil disetujui!');
    }

    /**
     * Proses Menolak (Reject) Seller
     */
    public function rejectSeller($id)
    {
        $seller = User::findOrFail($id);
        $seller->update(['seller_status' => 'rejected']);

        return redirect()->back()->with('success', 'Akun Seller telah ditolak.');
    }

    /**
     * Halaman Manajemen User
     * Melihat daftar semua pengguna.
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    /**
     * Menghapus User
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        
        // Validasi: Admin tidak boleh menghapus dirinya sendiri
        if ($user->id == auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
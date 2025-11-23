<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ---------------------------------------
        // 1. BUAT USER (PENGGUNA)
        // ---------------------------------------

        // A. Admin
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@tokokita.com',
            'password' => Hash::make('password'), // Password semua akun: 'password'
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        // B. Seller (Yang Sudah Disetujui/Approved)
        $seller = User::create([
            'name' => 'Juragan Laptop',
            'email' => 'seller@tokokita.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'seller_status' => 'approved', // Status langsung disetujui
            'phone' => '089876543210',
        ]);

        // Buatkan Toko untuk Seller ini otomatis
        $store = Store::create([
            'user_id' => $seller->id,
            'name' => 'Toko Laptop Maju Jaya',
            'slug' => 'toko-laptop-maju-jaya',
            'description' => 'Menjual berbagai macam laptop gaming dan kerja garansi resmi.',
            'image' => null, // Nanti bisa diupload manual lewat aplikasi
        ]);

        // C. Seller (Yang Masih Pending/Menunggu Persetujuan)
        User::create([
            'name' => 'Penjual Baru',
            'email' => 'pending@tokokita.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'seller_status' => 'pending', // Status masih menunggu
            'phone' => '081122334455',
        ]);

        // D. Buyer (Pembeli)
        User::create([
            'name' => 'Budi Pembeli',
            'email' => 'buyer@tokokita.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'phone' => '085566778899',
        ]);

        // ---------------------------------------
        // 2. BUAT KATEGORI PRODUK
        // ---------------------------------------
        
        $catElektronik = Category::create([
            'name' => 'Elektronik',
            'slug' => 'elektronik'
        ]);
        
        $catFashion = Category::create([
            'name' => 'Fashion Pria',
            'slug' => 'fashion-pria'
        ]);

        Category::create([
            'name' => 'Makanan & Minuman',
            'slug' => 'makanan-minuman'
        ]);

        // ---------------------------------------
        // 3. BUAT PRODUK CONTOH
        // ---------------------------------------
        // Produk ini milik Seller 'Juragan Laptop' di atas

        Product::create([
            'store_id' => $store->id,
            'category_id' => $catElektronik->id,
            'name' => 'Laptop Gaming ROG',
            'slug' => 'laptop-gaming-rog',
            'description' => 'Laptop spek dewa untuk main game berat. RAM 16GB, SSD 512GB.',
            'price' => 15000000,
            'stock' => 5,
            'image' => null,
        ]);

        Product::create([
            'store_id' => $store->id,
            'category_id' => $catElektronik->id,
            'name' => 'Mouse Wireless Logitech',
            'slug' => 'mouse-wireless-logitech',
            'description' => 'Mouse tanpa kabel, baterai awet hingga 1 tahun.',
            'price' => 150000,
            'stock' => 50,
            'image' => null,
        ]);
    }
}
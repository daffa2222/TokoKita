TokoKita - Sistem E-Commerce Laravel 

TokoKita adalah sistem E-Commerce modern berbasis Laravel yang dirancang untuk menyediakan platform jual-beli yang terstruktur, aman, dan mudah digunakan. Sistem ini melayani berbagai peran pengguna mulai dari Admin, Seller, hingga Buyer dengan fitur yang disesuaikan untuk menciptakan ekosistem belanja online yang lengkap.

📖 Overview

Sistem ini dibangun untuk memfasilitasi transaksi antara penjual dan pembeli dengan pengawasan administrator.

- Multi-Peran: Mendukung Admin, Seller, Buyer, dan Guest.

- Verifikasi Ketat: Seller baru harus melalui proses persetujuan Admin sebelum bisa berjualan.

- Manajemen Lengkap: Termasuk manajemen produk, pesanan (order), keranjang belanja, dan toko.

- Fitur Canggih: Dilengkapi dengan fitur wishlist, sorting harga, dan manajemen alamat pengiriman.

👥 User Levels (Peran Pengguna)

Aplikasi ini memiliki 4 tingkatan akses dengan wewenang yang berbeda:

1. Admin 👮‍♂️

Pengelola utama platform.

- Verifikasi Seller: Menyetujui (Approve) atau menolak (Reject) pendaftaran toko baru.

- Manajemen User: Melihat dan menghapus pengguna (Buyer/Seller) yang bermasalah.

- Kontrol Produk: Berhak menghapus produk dari toko manapun yang melanggar aturan.

- Manajemen Kategori: Membuat, mengedit, dan menghapus kategori produk.

2. Seller (Penjual) 🏪

Mitra yang menjual produk di platform.

- Pendaftaran: Mendaftar dan menunggu persetujuan Admin (Status: Pending).

- Manajemen Toko: Mengatur nama, deskripsi, dan foto profil toko.

- Manajemen Produk: Menambah, mengedit, dan menghapus produk (CRUD).

- Manajemen Pesanan: Memantau pesanan masuk dan memperbarui status pengiriman (Pending -> Processing -> Completed).

3. Buyer (Pembeli) 🛒

Pengguna yang berbelanja.

- Belanja: Menambah produk ke keranjang, mengubah jumlah, dan checkout.

- Transaksi: Membuat pesanan dan memantau riwayat statusnya.

- Ulasan: Memberikan rating (bintang) dan review pada produk yang sudah selesai dibeli (Verified Purchase).

- Profil: Mengelola informasi akun dan alamat pengiriman.

- Wishlist: Menyimpan produk favorit.

4. Public User (Guest) 👤

Pengunjung tanpa akun.

- Jelajah: Dapat melihat daftar produk, detail produk, dan melakukan pencarian.

- Terbatas: Harus login/register untuk bisa memasukkan barang ke keranjang atau checkout.

📦 CMS Modules (Fitur Utama)


1. Product Management (Seller)

- List Products: Melihat semua barang dagangan.

- Create Product: Upload produk dengan validasi ketat (Harga & Stok tidak boleh 0/negatif, Wajib gambar).

- Edit Product: Memperbarui info produk.

- Delete Product: Menghapus produk sendiri.


2. User Management (Admin)

- View User: Melihat semua pengguna terdaftar.

- Seller Verification: Memvalidasi pendaftaran toko (Pending -> Approved/Rejected).

- Edit User: Admin memiliki akses penuh mengubah data user lain (termasuk reset password & role).

- Delete User: Menghapus akun pengguna.


3. Cart Management (Buyer)

- Add to Cart: Menambah barang. Validasi stok otomatis.

- View Cart: Melihat ringkasan belanja. Bisa update jumlah (+/-) dan hapus item.

- Checkout: Memproses keranjang menjadi Order resmi. Alamat pengiriman otomatis terisi dari profil.


4. Store Management (Seller)

- Info Toko: Mengedit nama toko, deskripsi, dan logo toko agar lebih menarik.


5. Order Management (Core)

- Buyer: Melihat riwayat pesanan dan status terkini (Menunggu, Diproses, Selesai).

- Seller: Melihat pesanan masuk dan mengubah status pesanan.

- Review: Buyer hanya bisa memberi ulasan sekali setelah status pesanan "Selesai".


6. Category Management (Admin)

- CRUD Kategori: Admin mengelola kategori (Elektronik, Fashion, dll) untuk pengelompokan produk.


🌟 (Fitur Unggulan)

Fitur tambahan yang membuat TokoKita lebih spesial:


1. Filter & Sorting:

- Cari produk berdasarkan nama.

- Filter berdasarkan Kategori.

- Sorting Harga: Urutkan dari Termurah atau Termahal.


2. Alamat Pengiriman Cerdas:

- Buyer bisa menyimpan alamat di profil.

- Saat checkout, alamat otomatis terisi (auto-fill).

- Jika diubah saat checkout, alamat di profil ikut terupdate.


3. Favorite / Wishlist System:

- Simpan produk impian tanpa harus masuk keranjang.

- Halaman khusus untuk mengelola daftar keinginan.


💻 Layout & Tampilan

Desain antarmuka dibangun menggunakan Tailwind CSS dengan nuansa Indigo & Font Poppins yang modern, bersih, dan responsif.


- Login/Register: Desain Split-Screen modern dengan ilustrasi.

- Dashboard: Dashboard Admin & Seller yang informatif dengan statistik.

- Homepage: Hero banner menarik, grid produk responsif, dan kartu produk yang rapi.

- Navigasi: Menu yang menyesuaikan peran (Admin/Seller/Buyer) secara otomatis.


🚀 Instalasi & Menjalankan Proyek

Ikuti langkah ini untuk menjalankan TokoKita di komputer lokal Anda:


Prasyarat:

- PHP >= 8.1
- Composer
- Node.js & NPM
- Database MySQL


Langkah-langkah:


1. Clone Repository (atau ekstrak file zip)

git clone [https://github.com/username/tokokita.git](https://github.com/username/tokokita.git)
cd tokokita


2. Install Dependencies

composer install
npm install


3. Setup Environment

- Salin file .env.example menjadi .env.
- Atur koneksi database di .env:

DB_CONNECTION=mysql
DB_DATABASE=tokokita_db
DB_USERNAME=root
DB_PASSWORD=
APP_TIMEZONE='Asia/Makassar'


4. Generate Key & Migrate

php artisan key:generate
php artisan migrate


5. Seeding Data (PENTING) Jalankan seeder untuk membuat akun Admin, Seller, dan Produk contoh otomatis.

php artisan db:seed


6. Jalankan Server

npm run dev
php artisan serve


Buka browser di http://127.0.0.1:8000

🔑 Akun Demo (Hasil Seeding)

Gunakan akun berikut untuk pengujian :

| Role | Email | Password | Keterangan |
|----------|-----------|---------|-------------|
| Admin | admin@tokokita.com | password | Akses penuh sistem |
| Seller | daffa@gmail.com | password | Penjual aktif (Approved) |
| Seller | dalvin@gmail.com | password | Penjual baru (Menunggu Verifikasi) |
| Buyer | arya@gmail.com| password | Pembeli |



Sekian dan Terima Kasih. Good Luck!



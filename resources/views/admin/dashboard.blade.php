<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Dashboard Admin</h1>

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Card User -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Pengguna</p>
                    <p class="text-3xl font-bold text-slate-800">{{ $totalUsers }}</p>
                </div>

                <!-- Card Produk -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Produk</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ $totalProducts }}</p>
                </div>

                <!-- Card Order -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Transaksi</p>
                    <p class="text-3xl font-bold text-green-600">{{ $totalOrders }}</p>
                </div>

                <!-- Card Pending Seller -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Menunggu Verifikasi</p>
                    <p class="text-3xl font-bold text-orange-500">{{ $pendingSellers }}</p>
                    @if($pendingSellers > 0)
                        <span class="absolute top-4 right-4 w-3 h-3 bg-red-500 rounded-full animate-ping"></span>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.verify.sellers') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">Verifikasi Seller</h3>
                        <p class="text-xs text-slate-500">Setujui toko baru</p>
                    </div>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-full bg-pink-50 text-pink-600 flex items-center justify-center group-hover:bg-pink-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">Kelola Kategori</h3>
                        <p class="text-xs text-slate-500">Tambah kategori produk</p>
                    </div>
                </a>

                <a href="{{ route('admin.users') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">Manajemen User</h3>
                        <p class="text-xs text-slate-500">Lihat semua pengguna</p>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
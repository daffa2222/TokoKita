<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Dashboard Toko</h1>
                    <p class="text-slate-500 text-sm">Selamat datang kembali, {{ Auth::user()->name }}!</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('seller.products.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Produk
                    </a>
                </div>
            </div>

            <!-- Kartu Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Card 1: Produk -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Produk</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $totalProducts }}</p>
                    </div>
                </div>

                <!-- Card 2: Pesanan -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Pesanan Masuk</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $totalOrders }}</p>
                    </div>
                </div>

                <!-- Card 3: Pendapatan -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Action Area -->
            <div class="bg-indigo-600 rounded-2xl p-8 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-xl font-bold mb-2">Kelola Toko Anda</h3>
                    <p class="text-indigo-100 mb-4 max-w-xl">Update stok produk secara rutin dan proses pesanan secepat mungkin untuk mendapatkan rating bintang 5 dari pembeli.</p>
                    <a href="{{ route('seller.products.index') }}" class="inline-block bg-white text-indigo-600 px-6 py-2 rounded-lg font-bold hover:bg-indigo-50 transition">
                        Lihat Produk Saya
                    </a>
                </div>
                <!-- Hiasan background -->
                <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-10 translate-y-10">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
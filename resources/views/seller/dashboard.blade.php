<x-app-layout>
    <!-- Font Poppins -->
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="min-h-screen bg-[#F8FAFC]">
        
        <!-- HERO SECTION -->
        <div class="bg-gradient-to-r from-indigo-800 via-indigo-700 to-violet-800 pb-32 pt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-white">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight">Dashboard Toko</h2>
                        <p class="text-indigo-200 mt-1 text-sm">Kelola produk, pesanan, dan performa toko Anda.</p>
                    </div>
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full border border-white/20">
                        <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-xs font-bold border-2 border-indigo-300">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="font-medium text-sm">
                            {{ Auth::user()->store->name ?? Auth::user()->name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 pb-12">
            
            <!-- STATISTIK GRID -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Card 1: Total Produk -->
                <div class="bg-white rounded-[2rem] p-6 shadow-lg shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Produk</p>
                            <h3 class="text-4xl font-extrabold text-slate-800 mt-1">{{ $totalProducts }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span class="text-blue-500 text-sm">●</span>
                        <span>Item aktif di etalase</span>
                    </div>
                </div>

                <!-- Card 2: Pesanan Masuk -->
                <div class="bg-white rounded-[2rem] p-6 shadow-lg shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Pesanan Masuk</p>
                            <h3 class="text-4xl font-extrabold text-slate-800 mt-1">{{ $totalOrders }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                    </div>
                    @if($totalOrders > 0)
                        <div class="flex items-center gap-2 text-xs font-bold text-orange-600">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                            </span>
                            <span>Segera proses!</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                            <span class="text-slate-400">Belum ada pesanan baru</span>
                        </div>
                    @endif
                </div>

                <!-- Card 3: Total Pendapatan -->
                <div class="bg-white rounded-[2rem] p-6 shadow-lg shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Pendapatan</p>
                            <h3 class="text-3xl font-extrabold text-slate-800 mt-1 tracking-tight">Rp {{ number_format($revenue, 0, ',', '.') }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span class="text-green-500 text-sm">↗</span>
                        <span>Akumulasi penjualan</span>
                    </div>
                </div>
            </div>

            <!-- ACTION TITLE -->
            <div class="flex items-center gap-2 mb-6 px-1">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <h3 class="text-lg font-bold text-slate-800">Aksi Toko</h3>
            </div>

            <!-- ACTION GRID (Menu Cepat - 4 KOLOM) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Menu 1: Produk Saya (BARU DITAMBAHKAN) -->
                <a href="{{ route('seller.products.index') }}" class="group bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-300 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 group-hover:bg-blue-600 transition-colors flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 group-hover:text-blue-600 transition-colors">Produk Saya</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Lihat & edit barang</p>
                    </div>
                </a>

                <!-- Menu 2: Tambah Produk -->
                <a href="{{ route('seller.products.create') }}" class="group bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all duration-300 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 group-hover:bg-indigo-600 transition-colors flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">Tambah Produk</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Jual barang baru</p>
                    </div>
                </a>

                <!-- Menu 3: Cek Pesanan -->
                <a href="{{ route('seller.orders.index') }}" class="group bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all duration-300 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-green-50 group-hover:bg-green-600 transition-colors flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 group-hover:text-green-600 transition-colors">Pesanan Masuk</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Proses order pelanggan</p>
                    </div>
                </a>

                <!-- Menu 4: Pengaturan Toko -->
                <a href="{{ route('seller.store.edit') }}" class="group bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-pink-200 transition-all duration-300 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-pink-50 group-hover:bg-pink-600 transition-colors flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-pink-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 group-hover:text-pink-600 transition-colors">Pengaturan Toko</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Ubah nama & foto</p>
                    </div>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>
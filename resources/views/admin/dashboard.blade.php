<x-app-layout>
    <!-- Font Poppins -->
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="min-h-screen bg-[#F8FAFC]">
        
        <!-- HERO SECTION (Banner Admin - TIDAK DIUBAH WARNANYA) -->
        <div class="bg-gradient-to-r from-indigo-800 via-indigo-700 to-violet-800 pb-32 pt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-white">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight">Dashboard Administrator</h2>
                        <p class="text-indigo-200 mt-1 text-sm">Pantau dan kelola seluruh aktivitas platform TokoKita dari sini.</p>
                    </div>
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full border border-white/20">
                        <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-xs font-bold border-2 border-indigo-300">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="font-medium text-sm">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT (Overlap) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 pb-12">
            
            <!-- STATISTIK GRID (Simple & Creative Style) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                
                <!-- Card 1: Total Pengguna -->
                <div class="bg-white rounded-[2rem] p-6 shadow-lg shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Pengguna</p>
                            <h3 class="text-4xl font-extrabold text-slate-800 mt-1">{{ $totalUsers }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        <span>Akun Aktif</span>
                    </div>
                </div>

                <!-- Card 2: Total Produk -->
                <div class="bg-white rounded-[2rem] p-6 shadow-lg shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Produk</p>
                            <h3 class="text-4xl font-extrabold text-slate-800 mt-1">{{ $totalProducts }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span class="text-indigo-500 text-sm">↗</span>
                        <span>Terdaftar di sistem</span>
                    </div>
                </div>

                <!-- Card 3: Total Transaksi -->
                <div class="bg-white rounded-[2rem] p-6 shadow-lg shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Transaksi</p>
                            <h3 class="text-4xl font-extrabold text-slate-800 mt-1">{{ $totalOrders }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span class="text-green-500 text-sm">+</span>
                        <span>Pesanan masuk</span>
                    </div>
                </div>

                <!-- Card 4: Verifikasi -->
                <div class="bg-white rounded-[2rem] p-6 shadow-lg shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Perlu Verifikasi</p>
                            <h3 class="text-4xl font-extrabold {{ $pendingSellers > 0 ? 'text-orange-500' : 'text-slate-800' }} mt-1">{{ $pendingSellers }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    @if($pendingSellers > 0)
                        <div class="flex items-center gap-2 text-xs font-bold text-orange-600">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                            </span>
                            <span>Butuh tindakan!</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                            <span class="text-green-500">✓</span>
                            <span>Semua aman</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- QUICK ACTIONS TITLE -->
            <div class="flex items-center gap-2 mb-6 px-1">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <h3 class="text-lg font-bold text-slate-800">Aksi Cepat</h3>
            </div>

            <!-- QUICK ACTIONS GRID (Updated Style) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Menu: Verifikasi -->
                <a href="{{ route('admin.verify.sellers') }}" class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all duration-300 flex items-center gap-4 group">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 group-hover:bg-indigo-600 transition-colors flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">Verifikasi Seller</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Setujui toko baru</p>
                    </div>
                </a>

                <!-- Menu: Kelola Kategori -->
                <a href="{{ route('admin.categories.index') }}" class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-pink-200 transition-all duration-300 flex items-center gap-4 group">
                    <div class="w-14 h-14 rounded-2xl bg-pink-50 group-hover:bg-pink-600 transition-colors flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-pink-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 group-hover:text-pink-600 transition-colors">Kelola Kategori</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Atur kategori produk</p>
                    </div>
                </a>

                <!-- Menu: Manajemen User -->
                <a href="{{ route('admin.users.index') }}" class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-300 flex items-center gap-4 group">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 group-hover:bg-blue-600 transition-colors flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 group-hover:text-blue-600 transition-colors">Manajemen User</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Lihat semua pengguna</p>
                    </div>
                </a>

                <!-- Menu: Kelola Produk -->
                <a href="{{ route('admin.products') }}" class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-violet-200 transition-all duration-300 flex items-center gap-4 group">
                    <div class="w-14 h-14 rounded-2xl bg-violet-50 group-hover:bg-violet-600 transition-colors flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-violet-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 group-hover:text-violet-600 transition-colors">Kelola Produk</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Hapus produk melanggar</p>
                    </div>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>
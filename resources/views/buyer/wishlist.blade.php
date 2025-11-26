<x-app-layout>
    <!-- Font Poppins -->
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="bg-[#F8FAFC] min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Halaman -->
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center text-red-500 shadow-sm">
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Produk Favorit Saya</h1>
                    <p class="text-slate-500 text-sm">Simpan barang impianmu di sini agar tidak lupa.</p>
                </div>
            </div>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Grid Produk Wishlist -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($wishlists as $item)
                    <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 flex gap-5 items-center relative group hover:shadow-md hover:border-indigo-100 transition duration-300">
                        
                        <!-- Gambar Produk -->
                        <div class="w-24 h-24 bg-slate-50 rounded-2xl overflow-hidden flex-shrink-0 relative border border-slate-100">
                            <a href="{{ route('product.detail', $item->product->slug) }}">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="flex items-center justify-center h-full text-slate-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </a>
                        </div>
                        
                        <!-- Info Produk -->
                        <div class="flex-grow min-w-0 py-1">
                            <div class="mb-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">
                                    {{ $item->product->category->name }}
                                </span>
                            </div>
                            <h3 class="font-bold text-slate-800 line-clamp-1 text-base mb-1 group-hover:text-indigo-600 transition">
                                <a href="{{ route('product.detail', $item->product->slug) }}">{{ $item->product->name }}</a>
                            </h3>
                            <p class="text-indigo-600 font-bold text-lg mb-3">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                            
                            <!-- Tombol Aksi -->
                            <div class="flex gap-2">
                                <!-- Masuk Keranjang -->
                                <form action="{{ route('buyer.cart.add', $item->product_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs bg-slate-900 text-white px-3 py-2 rounded-lg font-bold hover:bg-indigo-600 transition shadow-sm flex items-center gap-1.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        + Keranjang
                                    </button>
                                </form>
                                
                                <!-- Hapus (Trash Icon) -->
                                <form action="{{ route('buyer.wishlist.toggle', $item->product_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-100 hover:text-red-600 transition" title="Hapus dari Favorit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-white rounded-[2rem] border-2 border-dashed border-slate-200">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-1">Belum ada produk favorit.</h3>
                        <p class="text-slate-500 text-sm mb-6">Simpan barang yang Anda suka agar mudah ditemukan nanti.</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Cari Produk Sekarang
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
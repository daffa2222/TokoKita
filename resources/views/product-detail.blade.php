<x-app-layout>
    <!-- Font Poppins -->
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="bg-slate-50 min-h-screen py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumb -->
            <nav class="flex items-center text-sm text-slate-500 mb-8">
                <a href="{{ route('home') }}" class="hover:text-indigo-600 font-medium transition">Beranda</a>
                <span class="mx-3 text-slate-300">/</span>
                <span class="text-slate-800 font-semibold truncate max-w-xs">{{ $product->name }}</span>
            </nav>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 items-start">
                
                <!-- KOLOM KIRI: GAMBAR -->
                <div class="md:col-span-5 sticky top-24">
                    <div class="bg-white p-4 rounded-3xl shadow-sm border border-slate-100">
                        <div class="aspect-square w-full bg-slate-50 rounded-2xl overflow-hidden flex items-center justify-center relative group">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="max-w-full max-h-full object-contain group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="text-slate-300 flex flex-col items-center">
                                    <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm font-medium">No Image Available</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: INFO PRODUK -->
                <div class="md:col-span-7 space-y-8">
                    
                    <!-- Main Card -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                        <!-- Badge Kategori -->
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold uppercase tracking-wider">
                                {{ $product->category->name }}
                            </span>
                        </div>

                        <h1 class="text-3xl font-bold text-slate-900 leading-tight mb-4">
                            {{ $product->name }}
                        </h1>
                        
                        <div class="flex items-center gap-6 text-sm mb-8 border-b border-slate-100 pb-6">
                            <div class="flex items-center text-yellow-500 gap-1.5 bg-yellow-50 px-3 py-1.5 rounded-lg">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-bold text-slate-800 text-lg">{{ number_format($rating, 1) ?? '0.0' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.6 8.6 0 01-5.358-1.882l-3.686 1.053a1 1 0 01-1.25-1.25l1.062-3.638A8.601 8.601 0 011 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path></svg>
                                <span class="font-medium">{{ $product->reviews->count() }} Ulasan</span>
                            </div>
                            <div class="text-slate-300">|</div>
                            <div class="text-slate-500">Stok: <span class="font-bold text-slate-800">{{ $product->stock }}</span></div>
                        </div>

                        <div class="mb-8">
                            <span class="text-4xl font-bold text-indigo-600 block mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-sm text-slate-400">Jaminan harga terbaik</span>
                        </div>
                        
                        <div class="prose prose-slate prose-sm text-slate-600 mb-8 leading-relaxed">
                            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide mb-2">Deskripsi Produk</h3>
                            <p class="whitespace-pre-line">{{ $product->description }}</p>
                        </div>

                        <!-- LINK PROFIL TOKO (DIPERBARUI) -->
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 mb-8 transition hover:border-indigo-200 group/store">
                            <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-600 text-lg">
                                {{ substr($product->store->name, 0, 1) }}
                            </div>
                            <div>
                                <a href="{{ route('store.show', $product->store->slug) }}" class="font-bold text-slate-800 text-lg hover:text-indigo-600 hover:underline transition">
                                    {{ $product->store->name }}
                                </a>
                                <div class="flex items-center gap-1 text-xs text-green-600 font-medium mt-0.5">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Penjual Terverifikasi
                                </div>
                            </div>
                            <a href="{{ route('store.show', $product->store->slug) }}" class="ml-auto text-sm font-bold text-indigo-600 bg-white px-4 py-2 rounded-lg border border-slate-200 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition">
                                Kunjungi Toko
                            </a>
                        </div>

                       <!-- Tombol Aksi -->
<div class="mt-4">
    @if($product->stock < 1)
        <!-- Stok Habis -->
        <button disabled class="w-full bg-slate-200 text-slate-500 py-4 rounded-xl font-bold text-lg cursor-not-allowed flex items-center justify-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
            Stok Habis
        </button>

    @elseif(auth()->check() && auth()->user()->role === 'buyer')
        <!-- Buyer Beli -->
        <form action="{{ route('buyer.cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold text-lg hover:bg-indigo-600 hover:shadow-lg hover:shadow-indigo-200 transition-all duration-300 transform active:scale-95 flex items-center justify-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Masukkan Keranjang
            </button>
        </form>

    @elseif(!auth()->check())
        <!-- Guest Login -->
        <a href="{{ route('login') }}" class="block text-center w-full bg-slate-900 text-white py-4 rounded-xl font-bold text-lg hover:bg-slate-800 transition shadow-lg hover:shadow-slate-300">
            Login untuk Membeli
        </a>
    @endif
</div>

                    <!-- Ulasan -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                            Ulasan Pembeli
                            <span class="bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded-md">{{ $product->reviews->count() }}</span>
                        </h3>
                        
                        <div class="space-y-6">
                            @forelse($product->reviews as $review)
                                <div class="border-b border-slate-50 pb-4 last:border-0 last:pb-0">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">
                                                {{ substr($review->user->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-bold text-slate-700">{{ $review->user->name }}</span>
                                        </div>
                                        <span class="text-xs text-slate-400">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex text-yellow-400 text-xs mb-2 pl-10">
                                        @for($i=0; $i<$review->rating; $i++) ★ @endfor
                                        @for($i=$review->rating; $i<5; $i++) <span class="text-slate-200">★</span> @endfor
                                    </div>
                                    <p class="text-slate-600 text-sm pl-10 leading-relaxed">"{{ $review->comment }}"</p>
                                </div>
                            @empty
                                <div class="text-center py-6">
                                    <p class="text-slate-400 text-sm italic">Belum ada ulasan untuk produk ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
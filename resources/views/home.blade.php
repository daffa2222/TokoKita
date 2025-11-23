<x-app-layout>
    <!-- Font Poppins Override -->
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <!-- Hero Section Simple -->
    <div class="bg-indigo-600 border-b border-indigo-500">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-4xl font-bold leading-tight mb-2">
                Temukan Barang Impianmu
            </h2>
            <p class="text-indigo-100 text-lg">Kualitas terbaik dengan harga yang bersahabat.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Search & Filter Bar (Floating) -->
            <div class="bg-white rounded-2xl shadow-xl shadow-indigo-100/50 p-5 mb-10 -mt-20 relative z-10 border border-slate-100">
                <form method="GET" action="{{ route('home') }}" class="flex flex-col md:flex-row gap-4 items-center">
                    <!-- Input Search -->
                    <div class="relative w-full flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" placeholder="Cari laptop, baju, makanan..." value="{{ request('search') }}" 
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 transition placeholder-slate-400">
                    </div>
                    
                    <!-- Select Category -->
                    <div class="w-full md:w-1/4">
                        <select name="category" class="w-full py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 transition cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Button Cari -->
                    <button type="submit" class="w-full md:w-auto bg-indigo-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-indigo-700 active:bg-indigo-800 transition shadow-lg shadow-indigo-200">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group">
                        
                        <!-- Image Container (Kotak Presisi) -->
                        <div class="relative w-full aspect-square bg-slate-100 overflow-hidden">
                            <a href="{{ route('product.detail', $product->slug) }}">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="flex items-center justify-center h-full text-slate-300 flex-col">
                                        <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-xs font-medium">No Image</span>
                                    </div>
                                @endif
                            </a>
                            
                            <!-- Category Badge -->
                            <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-indigo-700 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                {{ $product->category->name }}
                            </span>
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-4 flex flex-col justify-between flex-grow">
                            <div>
                                <a href="{{ route('product.detail', $product->slug) }}">
                                    <h3 class="text-base font-bold text-slate-800 line-clamp-2 leading-snug mb-1 group-hover:text-indigo-600 transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                <p class="text-xs text-slate-500 flex items-center gap-1 mb-3">
                                    <svg class="w-3 h-3 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    {{ $product->store->name }}
                                </p>
                            </div>
                            
                            <div class="mt-2 pt-3 border-t border-slate-50">
                                <div class="flex justify-between items-end mb-3">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] text-slate-400 uppercase font-semibold">Harga</span>
                                        <span class="text-lg font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                
                                @if(auth()->check() && auth()->user()->role === 'buyer')
                                    <form action="{{ route('buyer.cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-slate-900 text-white text-sm py-2.5 rounded-xl font-medium hover:bg-indigo-600 hover:shadow-lg hover:shadow-indigo-200 transition-all duration-300 flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            Keranjang
                                        </button>
                                    </form>
                                @elseif(!auth()->check())
                                    <a href="{{ route('login') }}" class="block text-center w-full bg-slate-100 text-slate-600 text-sm py-2.5 rounded-xl font-medium hover:bg-slate-200 transition">
                                        Login Beli
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-800">Produk tidak ditemukan</h3>
                        <p class="text-slate-500">Coba kata kunci lain atau ubah kategori.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
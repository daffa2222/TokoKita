<x-app-layout>
    <!-- Font Poppins -->
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <!-- HERO SECTION -->
    <div class="relative bg-indigo-600 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-indigo-500/30 border border-indigo-400 text-indigo-100 text-xs font-bold uppercase tracking-widest mb-6 backdrop-blur-sm">
                E-Commerce Terlengkap
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-6 leading-tight">
                Wujudkan Gaya Impianmu <br>
                <span class="text-indigo-200">Mulai dari Sini!</span>
            </h1>
            <p class="text-lg text-indigo-100 max-w-2xl mx-auto mb-10 leading-relaxed">
                Ribuan produk original 💯, harga bersahabat 🏷, dan pengiriman kilat 🚀. 
                Nikmati pengalaman belanja aman & nyaman cuma di <span class="font-bold text-white">TokoKita</span>.

            </p>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10 pb-20">
        
        <!-- SEARCH BAR (Sama seperti sebelumnya) -->
        <div class="bg-white rounded-2xl shadow-xl shadow-indigo-100/50 p-5 mb-12 border border-slate-100">
            <form method="GET" action="{{ route('home') }}" class="flex flex-col lg:flex-row gap-4 lg:items-center">
                <div class="relative w-full lg:flex-1 group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-6 w-6 text-slate-400 group-focus-within:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" placeholder="Mau cari apa hari ini?" value="{{ request('search') }}" 
                        class="w-full pl-12 pr-4 py-4 bg-slate-50 border-0 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white text-slate-800 text-base placeholder-slate-400 transition font-medium shadow-sm">
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 lg:w-auto">
                    <div class="grid grid-cols-2 gap-4 w-full sm:w-auto">
                        <div class="relative min-w-[160px]">
                            <select name="category" class="w-full py-4 pl-4 pr-10 bg-slate-50 border-0 rounded-xl focus:ring-2 focus:ring-indigo-500 text-slate-700 font-medium cursor-pointer appearance-none shadow-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <div class="relative min-w-[160px]">
                            <select name="sort" class="w-full py-4 pl-4 pr-10 bg-slate-50 border-0 rounded-xl focus:ring-2 focus:ring-indigo-500 text-slate-700 font-medium cursor-pointer appearance-none shadow-sm">
                                <option value="">Urutkan...</option>
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="low_high" {{ request('sort') == 'low_high' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="high_low" {{ request('sort') == 'high_low' ? 'selected' : '' }}>Harga Tertinggi</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full sm:w-auto bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-indigo-700 active:scale-95 transition shadow-lg shadow-indigo-200 whitespace-nowrap">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- PRODUCT GRID -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 md:gap-8">
            @forelse($products as $product)
                <div class="group bg-white rounded-3xl p-3 border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-100/50 hover:-translate-y-2 transition-all duration-300 relative flex flex-col h-full">
                    
                    <!-- Wishlist Button -->
                    @if(auth()->check() && auth()->user()->role === 'buyer')
                        <form action="{{ route('buyer.wishlist.toggle', $product->id) }}" method="POST" class="absolute top-5 right-5 z-20">
                            @csrf
                            <button type="submit" class="w-10 h-10 rounded-full bg-white/90 backdrop-blur shadow-md flex items-center justify-center hover:bg-red-50 transition group/heart">
                                @php 
                                    $isLiked = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists(); 
                                @endphp
                                <svg class="w-5 h-5 {{ $isLiked ? 'text-red-500 fill-current' : 'text-slate-300 group-hover/heart:text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </form>
                    @endif

                    <!-- Image -->
                    <div class="relative w-full aspect-square rounded-2xl overflow-hidden bg-slate-100 mb-4 flex-shrink-0">
                        <a href="{{ route('product.detail', $product->slug) }}" class="block w-full h-full">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300 flex-col">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-xs font-medium">No Image</span>
                                </div>
                            @endif
                        </a>
                        <span class="absolute top-3 left-3 bg-indigo-600/90 backdrop-blur text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-lg">
                            {{ $product->category->name }}
                        </span>
                    </div>
                    
                    <!-- Info Produk -->
                    <div class="px-2 pb-2 flex flex-col flex-grow">
                        <a href="{{ route('product.detail', $product->slug) }}">
                            <h3 class="text-lg font-bold text-slate-800 line-clamp-1 mb-1 group-hover:text-indigo-600 transition-colors">
                                {{ $product->name }}
                            </h3>
                        </a>
                        
                        <!-- LINK TOKO (DIPERBARUI) -->
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-5 h-5 rounded-full bg-indigo-50 flex items-center justify-center text-[10px] font-bold text-indigo-600 flex-shrink-0">
                                {{ substr($product->store->name, 0, 1) }}
                            </div>
                            <!-- Nama Toko Menjadi Link -->
                            <a href="{{ route('store.show', $product->store->slug) }}" class="text-xs text-slate-500 truncate hover:text-indigo-600 hover:underline transition font-medium">
                                {{ $product->store->name }}
                            </a>
                        </div>
                        
                        <div class="flex-grow"></div>

                        <div class="mt-2 pt-3 border-t border-slate-50">
                            <div class="flex flex-col mb-3">
                                <span class="text-xs text-slate-400 font-medium">Harga</span>
                                <span class="text-xl font-extrabold text-indigo-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                            
                            @if(auth()->check() && auth()->user()->role === 'buyer')
                                <form action="{{ route('buyer.cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-xl font-bold text-sm hover:bg-indigo-600 transition shadow-lg shadow-slate-200 group-hover:shadow-indigo-200 flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        + Keranjang
                                    </button>
                                </form>
                            @elseif(!auth()->check())
                                <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 bg-slate-900 text-white py-3 rounded-xl font-bold text-sm hover:bg-indigo-600 transition shadow-lg shadow-slate-200 group-hover:shadow-indigo-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    + Keranjang
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="inline-block p-6 rounded-full bg-indigo-50 mb-4">
                        <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Produk tidak ditemukan</h3>
                    <p class="text-slate-500 mt-2">Coba cari kata kunci lain atau reset filter.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-16">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <!-- Font Poppins -->
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <!-- HEADER TOKO (Banner Putih) -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
                
                <!-- Foto Toko -->
                <div class="relative group">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-full bg-slate-50 border-4 border-white shadow-lg overflow-hidden flex-shrink-0">
                        @if($store->image)
                            <img src="{{ asset('storage/' . $store->image) }}" class="w-full h-full object-cover">
                        @else
                            <!-- Avatar Inisial Toko -->
                            <div class="flex items-center justify-center h-full bg-indigo-50 text-indigo-400 font-bold text-5xl">
                                {{ substr($store->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <!-- Badge Verified -->
                    <div class="absolute bottom-2 right-2 bg-blue-500 text-white p-1.5 rounded-full border-2 border-white shadow-sm" title="Toko Terverifikasi">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>

                <!-- Info Toko -->
                <div class="flex-grow">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-2 tracking-tight">{{ $store->name }}</h1>
                    
                    <div class="flex flex-wrap justify-center md:justify-start items-center gap-4 text-sm text-slate-500 mb-4">
                        <span class="flex items-center gap-1 bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full font-bold text-xs uppercase tracking-wider border border-indigo-100">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                            Official Store
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Bergabung {{ $store->created_at->isoFormat('MMMM Y') }}
                        </span>
                        <span class="flex items-center gap-1 font-bold text-slate-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            {{ $products->total() }} Produk
                        </span>
                    </div>

                    <p class="text-slate-600 max-w-2xl mx-auto md:mx-0 leading-relaxed text-sm md:text-base">
                        {{ $store->description ?? 'Belum ada deskripsi toko.' }}
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- ETALASE PRODUK -->
    <div class="bg-[#F8FAFC] min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-3 mb-8 px-2">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-600 shadow-sm border border-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Etalase Produk</h3>
            </div>

            <!-- Grid Produk -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @forelse($products as $product)
                    <div class="group bg-white rounded-3xl p-3 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-indigo-100/50 hover:-translate-y-1 transition-all duration-300 relative flex flex-col h-full">
                        
                        <!-- Wishlist Button (Floating) -->
                        @if(auth()->check() && auth()->user()->role === 'buyer')
                            <form action="{{ route('buyer.wishlist.toggle', $product->id) }}" method="POST" class="absolute top-5 right-5 z-20">
                                @csrf
                                <button type="submit" class="w-9 h-9 rounded-full bg-white/90 backdrop-blur shadow-md flex items-center justify-center hover:bg-red-50 transition group/heart border border-slate-100">
                                    @php 
                                        $isLiked = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists(); 
                                    @endphp
                                    <svg class="w-5 h-5 {{ $isLiked ? 'text-red-500 fill-current' : 'text-slate-300 group-hover/heart:text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </form>
                        @endif

                        <!-- Gambar (Kotak) -->
                        <div class="relative w-full aspect-square bg-slate-100 rounded-2xl overflow-hidden mb-4 flex-shrink-0">
                            <a href="{{ route('product.detail', $product->slug) }}" class="block w-full h-full">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="flex items-center justify-center h-full text-slate-300">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </a>
                            <!-- Badge Kategori -->
                            <span class="absolute top-3 left-3 bg-indigo-600/90 backdrop-blur text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-lg">
                                {{ $product->category->name }}
                            </span>
                        </div>
                        
                        <!-- Info -->
                        <div class="px-2 pb-2 flex flex-col flex-grow">
                            <a href="{{ route('product.detail', $product->slug) }}">
                                <h3 class="text-base font-bold text-slate-800 line-clamp-2 mb-1 group-hover:text-indigo-600 transition">{{ $product->name }}</h3>
                            </a>
                            
                            <!-- Spacer -->
                            <div class="flex-grow"></div>

                            <div class="mt-2 pt-3 border-t border-slate-50">
                                <div class="flex flex-col mb-3">
                                    <span class="text-xs text-slate-400 font-medium">Harga</span>
                                    <span class="text-xl font-extrabold text-indigo-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- TOMBOL KERANJANG (BARU DITAMBAHKAN) -->
                                @if(auth()->check() && auth()->user()->role === 'buyer')
                                    <!-- Tombol untuk Buyer Login -->
                                    <form action="{{ route('buyer.cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-slate-900 text-white py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-600 transition shadow-lg shadow-slate-200 group-hover:shadow-indigo-200 flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            + Keranjang
                                        </button>
                                    </form>
                                @elseif(!auth()->check())
                                    <!-- Tombol untuk Tamu (Redirect ke Login) -->
                                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 bg-slate-900 text-white py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-600 transition shadow-lg shadow-slate-200 group-hover:shadow-indigo-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        + Keranjang
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <p class="text-slate-400">Toko ini belum memiliki produk.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
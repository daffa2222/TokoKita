<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <!-- HEADER TOKO -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center gap-8">
                
                <!-- Foto Toko -->
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full bg-slate-100 border-4 border-white shadow-lg overflow-hidden flex-shrink-0 relative">
                    @if($store->image)
                        <img src="{{ asset('storage/' . $store->image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full bg-indigo-50 text-indigo-300 font-bold text-4xl">
                            {{ substr($store->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Info Toko -->
                <div class="text-center md:text-left flex-grow">
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">{{ $store->name }}</h1>
                    
                    <div class="flex flex-wrap justify-center md:justify-start items-center gap-4 text-sm text-slate-500 mb-4">
                        <span class="flex items-center gap-1 bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Official Seller
                        </span>
                        <span>Bergabung {{ $store->created_at->diffForHumans() }}</span>
                        <span>{{ $products->total() }} Produk</span>
                    </div>

                    <p class="text-slate-600 max-w-2xl mx-auto md:mx-0 leading-relaxed">
                        {{ $store->description ?? 'Belum ada deskripsi toko.' }}
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- PRODUK TOKO -->
    <div class="bg-[#F8FAFC] min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Etalase Produk
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @forelse($products as $product)
                    <div class="group bg-white rounded-2xl border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full relative">
                        <!-- Gambar -->
                        <div class="relative w-full aspect-square bg-slate-100 overflow-hidden">
                            <a href="{{ route('product.detail', $product->slug) }}">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="flex items-center justify-center h-full text-slate-300">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </a>
                        </div>
                        
                        <!-- Info -->
                        <div class="p-4 flex flex-col flex-grow justify-between">
                            <div>
                                <a href="{{ route('product.detail', $product->slug) }}">
                                    <h3 class="text-sm font-bold text-slate-800 line-clamp-2 mb-1 group-hover:text-indigo-600 transition">{{ $product->name }}</h3>
                                </a>
                                <p class="text-xs text-slate-500 mb-2">{{ $product->category->name }}</p>
                            </div>
                            
                            <div class="mt-2 border-t border-slate-50 pt-2">
                                <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
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
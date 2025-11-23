<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="bg-slate-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Keranjang Belanja</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- KOLOM KIRI: DAFTAR BARANG -->
                <div class="lg:col-span-2 space-y-4">
                    @forelse($carts as $cart)
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex gap-4 items-center">
                            <!-- Gambar Kecil -->
                            <div class="w-20 h-20 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                                @if($cart->product->image)
                                    <img src="{{ asset('storage/' . $cart->product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-slate-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Info Barang -->
                            <div class="flex-grow">
                                <h3 class="font-bold text-slate-800">{{ $cart->product->name }}</h3>
                                <p class="text-xs text-slate-500 mb-1">Toko: {{ $cart->product->store->name }}</p>
                                <p class="text-indigo-600 font-bold">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                            </div>

                            <!-- Jumlah & Hapus -->
                            <div class="text-right">
                                <p class="text-sm text-slate-600 mb-2">Jml: <span class="font-bold">{{ $cart->quantity }}</span></p>
                                
                                <form action="{{ route('buyer.cart.delete', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center gap-1 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-8 rounded-2xl border border-dashed border-slate-300 text-center">
                            <div class="inline-flex bg-indigo-50 p-4 rounded-full text-indigo-400 mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <p class="text-slate-500 font-medium">Keranjang masih kosong.</p>
                            <a href="{{ route('home') }}" class="text-indigo-600 font-bold hover:underline mt-2 inline-block">Mulai Belanja</a>
                        </div>
                    @endforelse
                </div>

                <!-- KOLOM KANAN: RINGKASAN BELANJA -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-3xl shadow-lg shadow-indigo-100 border border-slate-100 sticky top-24">
                        <h3 class="font-bold text-lg text-slate-800 mb-4">Ringkasan Pesanan</h3>
                        
                        <div class="flex justify-between mb-2 text-slate-600">
                            <span>Total Item</span>
                            <span>{{ $carts->sum('quantity') }} barang</span>
                        </div>
                        
                        <div class="border-t border-slate-100 my-4"></div>
                        
                        <div class="flex justify-between mb-6">
                            <span class="font-bold text-slate-800">Total Harga</span>
                            <span class="font-bold text-2xl text-indigo-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        @if($carts->count() > 0)
                            <form action="{{ route('buyer.checkout') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Alamat Pengiriman</label>
                                    <textarea name="address" rows="3" required class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Jalan, Nomor Rumah, Kota...">{{ Auth::user()->address }}</textarea>
                                </div>

                                <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 active:scale-95">
                                    Checkout Sekarang
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-slate-200 text-slate-400 py-3.5 rounded-xl font-bold cursor-not-allowed">
                                Checkout
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
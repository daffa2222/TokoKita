<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="bg-[#F8FAFC] min-h-screen py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-3 mb-8">
                <div class="bg-indigo-100 p-3 rounded-xl text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Riwayat Pesanan</h1>
                    <p class="text-slate-500 text-sm">Pantau status pengiriman barang Anda.</p>
                </div>
            </div>

            <div class="space-y-6">
                @forelse($orders as $order)
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden transition hover:shadow-md">
                        
                        <!-- Header Order -->
                        <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-100 flex flex-col md:flex-row justify-between md:items-center gap-4">
                            <div class="flex items-center gap-6">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Invoice</p>
                                    <p class="font-mono font-bold text-slate-700 text-sm bg-white border border-slate-200 px-2 py-1 rounded-md">{{ $order->invoice_code }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Waktu Pemesanan</p>
                                    
                                    <!-- PERBAIKAN ZONA WAKTU DI SINI -->
                                    <div class="flex flex-col">
                                        <!-- Paksa konversi ke Asia/Makassar sebelum diformat -->
                                        <span class="text-sm font-bold text-slate-700">
                                            {{ $order->created_at->setTimezone('Asia/Makassar')->isoFormat('D MMMM Y') }}
                                        </span>
                                        <span class="text-xs text-slate-500 font-mono">
                                            Pukul {{ $order->created_at->setTimezone('Asia/Makassar')->format('H:i') }} WITA
                                        </span>
                                    </div>

                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5 text-right">Total Bayar</p>
                                    <p class="font-bold text-indigo-600 text-lg text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    @php
                                        $statusColor = match($order->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                            'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'shipped' => 'bg-purple-100 text-purple-700 border-purple-200',
                                            'completed' => 'bg-green-100 text-green-700 border-green-200',
                                            'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                            default => 'bg-gray-100 text-gray-700 border-gray-200'
                                        };
                                        $statusLabel = match($order->status) {
                                            'pending' => 'Menunggu Pembayaran',
                                            'processing' => 'Sedang Diproses',
                                            'shipped' => 'Dalam Pengiriman',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                            default => ucfirst($order->status)
                                        };
                                    @endphp
                                    <span class="px-3 py-1.5 rounded-full text-xs font-bold border {{ $statusColor }}">
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Body Order -->
                        <div class="p-6">
                            <div class="space-y-6">
                                @foreach($order->items as $item)
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                        <!-- Gambar Kecil -->
                                        <div class="w-16 h-16 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 border border-slate-200">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        
                                        <div class="flex-grow">
                                            <h4 class="font-bold text-slate-800 text-sm mb-1">{{ $item->product->name }}</h4>
                                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                                <span>{{ $item->quantity }} barang</span>
                                                <span>•</span>
                                                <span>Rp {{ number_format($item->price, 0, ',', '.') }} / pcs</span>
                                            </div>
                                        </div>

                                        <!-- Tombol Review -->
                                        @if($order->status == 'completed')
                                            <button onclick="document.getElementById('review-form-{{ $item->id }}').classList.toggle('hidden')" 
                                                class="bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition shadow-sm">
                                                Beri Ulasan
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Form Review (Hidden) -->
                                    @if($order->status == 'completed')
                                        <div id="review-form-{{ $item->id }}" class="hidden mt-3 ml-0 sm:ml-20 bg-slate-50 p-5 rounded-2xl border border-slate-200 relative">
                                            <!-- Segitiga panah -->
                                            <div class="absolute top-[-6px] right-10 w-3 h-3 bg-slate-50 border-t border-l border-slate-200 transform rotate-45"></div>
                                            
                                            <form action="{{ route('buyer.review.store', $item->product_id) }}" method="POST">
                                                @csrf
                                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Ulasan Anda</p>
                                                
                                                <div class="mb-3">
                                                    <select name="rating" class="w-full md:w-auto text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                                        <option value="5">⭐⭐⭐⭐⭐ - Sangat Puas</option>
                                                        <option value="4">⭐⭐⭐⭐ - Bagus</option>
                                                        <option value="3">⭐⭐⭐ - Biasa Saja</option>
                                                        <option value="2">⭐⭐ - Kurang</option>
                                                        <option value="1">⭐ - Kecewa</option>
                                                    </select>
                                                </div>
                                                
                                                <textarea name="comment" rows="2" placeholder="Ceritakan pengalaman Anda..." class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 mb-3 resize-none"></textarea>
                                                
                                                <div class="flex justify-end">
                                                    <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-indigo-700 transition shadow-md shadow-indigo-200">
                                                        Kirim Ulasan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">Belum ada riwayat pesanan.</h3>
                        <p class="text-slate-500 text-sm mb-6">Ayo mulai belanja barang impianmu sekarang!</p>
                        <a href="{{ route('home') }}" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 inline-block">
                            Ke Beranda
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="bg-slate-50 min-h-screen py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Riwayat Pesanan Saya</h1>

            <div class="space-y-6">
                @forelse($orders as $order)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <!-- Header Order -->
                        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex flex-col md:flex-row justify-between md:items-center gap-4">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Invoice</p>
                                <p class="font-bold text-slate-700 font-mono">{{ $order->invoice_code }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal</p>
                                <p class="text-sm text-slate-600">{{ $order->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Belanja</p>
                                <p class="font-bold text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                @php
                                    $statusColor = match($order->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'paid', 'processing' => 'bg-blue-100 text-blue-800',
                                        'shipped' => 'bg-purple-100 text-purple-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                    $statusLabel = match($order->status) {
                                        'pending' => 'Menunggu Pembayaran',
                                        'paid' => 'Sudah Dibayar',
                                        'processing' => 'Sedang Diproses',
                                        'shipped' => 'Dalam Pengiriman',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                        default => ucfirst($order->status)
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>

                        <!-- Body Order (Daftar Barang) -->
                        <div class="p-6">
                            <h4 class="text-sm font-bold text-slate-700 mb-4">Barang yang dibeli:</h4>
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                    <div class="flex items-center gap-4">
                                        <!-- Gambar Kecil -->
                                        <div class="w-16 h-16 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        
                                        <div class="flex-grow">
                                            <p class="font-bold text-slate-800">{{ $item->product->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>

                                        <!-- Tombol Review (Hanya jika Selesai) -->
                                        @if($order->status == 'completed')
                                            <!-- Kita gunakan modal sederhana atau form langsung -->
                                            <button onclick="document.getElementById('review-form-{{ $item->id }}').classList.toggle('hidden')" 
                                                class="text-xs bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg font-bold hover:bg-indigo-100 transition">
                                                Beri Ulasan
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Form Review Tersembunyi -->
                                    @if($order->status == 'completed')
                                        <div id="review-form-{{ $item->id }}" class="hidden mt-2 ml-20 bg-slate-50 p-4 rounded-xl border border-slate-200">
                                            <form action="{{ route('buyer.review.store', $item->product_id) }}" method="POST">
                                                @csrf
                                                <p class="text-xs font-bold text-slate-500 mb-2">Tulis ulasan untuk {{ $item->product->name }}</p>
                                                
                                                <div class="flex gap-2 mb-2">
                                                    <select name="rating" class="text-sm rounded-lg border-slate-300">
                                                        <option value="5">★★★★★ (5)</option>
                                                        <option value="4">★★★★ (4)</option>
                                                        <option value="3">★★★ (3)</option>
                                                        <option value="2">★★ (2)</option>
                                                        <option value="1">★ (1)</option>
                                                    </select>
                                                </div>
                                                
                                                <textarea name="comment" rows="2" placeholder="Bagaimana kualitas produknya?" class="w-full text-sm rounded-lg border-slate-300 mb-2"></textarea>
                                                
                                                <button type="submit" class="bg-indigo-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-700">Kirim Ulasan</button>
                                            </form>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <p class="text-slate-500">Belum ada riwayat pesanan.</p>
                        <a href="{{ route('home') }}" class="text-indigo-600 font-bold hover:underline">Ayo belanja sekarang!</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
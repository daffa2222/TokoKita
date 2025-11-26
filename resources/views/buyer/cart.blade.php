<x-app-layout>
    <!-- Font Poppins -->
    <style> 
        * { font-family: 'Poppins', sans-serif; } 
        /* Animasi mengambang halus */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }
    </style>

    <div class="bg-[#F8FAFC] min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Halaman -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">Keranjang Belanja</h1>
                        <p class="text-slate-500 text-sm">Pilih barang yang ingin Anda checkout.</p>
                    </div>
                </div>

                <!-- JAM REALTIME -->
                <div class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl shadow-sm flex items-center gap-3 text-slate-600">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="text-right leading-tight">
                        <p id="current-date" class="text-xs font-bold uppercase tracking-wider text-slate-400"></p>
                        <p id="current-time" class="text-lg font-mono font-bold text-indigo-600"></p>
                    </div>
                </div>
            </div>

            <!-- Notifikasi -->
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2 shadow-sm">
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2 shadow-sm">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- FORM CHECKOUT -->
            <form action="{{ route('buyer.checkout') }}" method="POST" id="checkoutForm">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- KOLOM KIRI: DAFTAR BARANG -->
                    <div class="lg:col-span-2 space-y-4">
                        
                        @if($carts->count() > 0)
                            <div class="bg-white p-4 rounded-2xl border border-slate-100 flex items-center gap-4 shadow-sm">
                                <input type="checkbox" id="select-all" checked class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 transition cursor-pointer">
                                <label for="select-all" class="font-bold text-slate-700 cursor-pointer select-none">Pilih Semua Barang</label>
                            </div>
                        @endif

                        @forelse($carts as $cart)
                            <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 flex gap-4 items-center transition hover:shadow-md group relative">
                                
                                <!-- CHECKBOX ITEM -->
                                <div class="flex-shrink-0">
                                    <input type="checkbox" name="selected_items[]" value="{{ $cart->id }}" checked
                                        class="item-checkbox w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 transition cursor-pointer"
                                        data-price="{{ $cart->product->price * $cart->quantity }}">
                                </div>

                                <!-- Gambar Produk -->
                                <div class="w-24 h-24 bg-slate-50 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-100 relative ml-2">
                                    <a href="{{ route('product.detail', $cart->product->slug) }}" class="block w-full h-full">
                                        @if($cart->product->image)
                                            <img src="{{ asset('storage/' . $cart->product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        @else
                                            <div class="flex items-center justify-center h-full text-slate-300 flex-col">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </a>
                                </div>

                                <!-- Info Barang -->
                                <div class="flex-grow min-w-0 w-full sm:w-auto">
                                    <div class="mb-1">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">
                                            {{ $cart->product->category->name }}
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-slate-800 text-lg leading-tight mb-1 truncate hover:text-indigo-600 transition">
                                        <a href="{{ route('product.detail', $cart->product->slug) }}">{{ $cart->product->name }}</a>
                                    </h3>
                                    <p class="text-xs text-slate-500 mb-2">{{ $cart->product->store->name }}</p>
                                    <p class="text-indigo-600 font-bold text-lg">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                </div>

                                <!-- Kontrol Jumlah -->
                                <div class="flex flex-col items-end gap-3">
                                    <div class="flex items-center bg-slate-50 rounded-xl border border-slate-200 p-1 shadow-sm">
                                        <button type="button" onclick="updateQty('{{ route('buyer.cart.update', $cart->id) }}', 'decrease')" 
                                            class="w-8 h-8 flex items-center justify-center bg-white rounded-lg text-slate-600 hover:text-indigo-600 shadow-sm hover:shadow transition {{ $cart->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                            −
                                        </button>

                                        <span class="w-10 text-center font-bold text-slate-800 text-sm">{{ $cart->quantity }}</span>

                                        <button type="button" onclick="updateQty('{{ route('buyer.cart.update', $cart->id) }}', 'increase')"
                                            class="w-8 h-8 flex items-center justify-center bg-indigo-600 rounded-lg text-white hover:bg-indigo-700 shadow-md hover:shadow-lg transition">
                                            +
                                        </button>
                                    </div>

                                    <button type="button" onclick="deleteItem('{{ route('buyer.cart.delete', $cart->id) }}')" class="text-slate-400 hover:text-red-500 text-xs font-bold flex items-center gap-1 px-2 py-1 rounded-lg hover:bg-red-50 transition">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @empty
                            <!-- TAMPILAN KOSONG YANG BARU & KREATIF -->
                            <div class="col-span-full bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-10 text-center relative overflow-hidden">
                                <!-- Background Decoration Blobs -->
                                <div class="absolute top-[-50px] left-[-50px] w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-60"></div>
                                <div class="absolute bottom-[-50px] right-[-50px] w-40 h-40 bg-pink-50 rounded-full blur-3xl opacity-60"></div>

                                <div class="relative z-10 py-12">
                                    <!-- Ilustrasi Utama -->
                                    <div class="mx-auto w-40 h-40 bg-indigo-50 rounded-full flex items-center justify-center mb-6 animate-float relative">
                                        <svg class="w-20 h-20 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        <!-- Icon Hiasan Melayang -->
                                        <div class="absolute top-0 right-0 bg-white p-2 rounded-full shadow-md text-xl animate-bounce" style="animation-delay: 0.1s">🛍️</div>
                                        <div class="absolute bottom-2 left-2 bg-white p-2 rounded-full shadow-md text-xl animate-bounce" style="animation-delay: 0.3s">✨</div>
                                    </div>

                                    <h3 class="text-2xl font-extrabold text-slate-800 mb-3">Ups! Keranjangmu Masih Sepi Nih...</h3>
                                    <p class="text-slate-500 text-base mb-8 max-w-md mx-auto leading-relaxed">
                                        Jangan biarkan keranjangmu kedinginan. Yuk, isi dengan barang-barang impianmu dan mulai checkout sekarang! 🚀
                                    </p>
                                    
                                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:shadow-xl hover:shadow-indigo-200 hover:-translate-y-1 transition-all duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        Mulai Belanja
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- KOLOM KANAN: RINGKASAN (Sticky) -->
                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 md:p-8 rounded-[2rem] shadow-xl shadow-indigo-100/50 border border-slate-100 sticky top-24">
                            <h3 class="font-bold text-lg text-slate-800 mb-6 border-b border-slate-100 pb-4">
                                Ringkasan Pesanan
                            </h3>
                            
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-sm text-slate-600">
                                    <span>Total Item Dipilih</span>
                                    <span class="font-bold bg-slate-100 px-3 py-1 rounded-lg text-slate-700" id="total-items">0 item</span>
                                </div>
                                <div class="border-t border-dashed border-slate-200 pt-4 mt-2 flex justify-between items-end">
                                    <div>
                                        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Bayar</span>
                                        <p class="font-extrabold text-3xl text-indigo-600 mt-1" id="total-price">Rp 0</p>
                                    </div>
                                </div>
                            </div>

                            @if($carts->count() > 0)
                                <div class="mb-6">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Alamat Pengiriman</label>
                                    <textarea name="address" rows="3" required 
                                        class="w-full bg-slate-50 border-slate-200 rounded-2xl text-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400 transition p-4 resize-none shadow-inner" 
                                        placeholder="Alamat lengkap...">{{ Auth::user()->address }}</textarea>
                                </div>

                                <button type="submit" id="checkout-btn" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-indigo-600 transition shadow-lg shadow-slate-200 hover:shadow-indigo-200 transform active:scale-95 flex justify-center items-center gap-3">
                                    <span>Checkout Sekarang</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </button>
                            @else
                                <button disabled class="w-full bg-slate-100 text-slate-400 py-4 rounded-2xl font-bold cursor-not-allowed border border-slate-200 flex justify-center items-center gap-2 opacity-70">
                                    Keranjang Kosong
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- HIDDEN FORMS FOR JS ACTIONS -->
    <form id="action-form" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="_method" id="form-method">
        <input type="hidden" name="action" id="form-action">
    </form>

    <!-- JAVASCRIPT -->
    <script>
        // 1. JAM REALTIME
        function updateTime() {
            const now = new Date();
            const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', optionsDate);
            document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace('.', ':') + ' WITA'; // Sesuaikan label zona waktu
        }
        setInterval(updateTime, 1000);
        updateTime();

        // 2. HITUNG TOTAL HARGA BERDASARKAN CENTANG
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const selectAll = document.getElementById('select-all');
        const totalPriceEl = document.getElementById('total-price');
        const totalItemsEl = document.getElementById('total-items');
        const checkoutBtn = document.getElementById('checkout-btn');

        function calculateTotal() {
            let total = 0;
            let count = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseFloat(cb.dataset.price);
                    count++;
                }
            });
            
            totalPriceEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
            totalItemsEl.textContent = count + ' item';
            
            if(checkoutBtn) {
                if(count === 0) {
                    checkoutBtn.disabled = true;
                    checkoutBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    checkoutBtn.classList.remove('hover:bg-indigo-600', 'hover:shadow-indigo-200');
                } else {
                    checkoutBtn.disabled = false;
                    checkoutBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    checkoutBtn.classList.add('hover:bg-indigo-600', 'hover:shadow-indigo-200');
                }
            }
        }

        if(checkboxes.length > 0) {
            checkboxes.forEach(cb => cb.addEventListener('change', calculateTotal));
            if(selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    calculateTotal();
                });
            }
            calculateTotal();
        }

        // 3. ACTION HELPERS
        function updateQty(url, action) {
            const form = document.getElementById('action-form');
            form.action = url;
            document.getElementById('form-method').value = 'PATCH';
            document.getElementById('form-action').value = action;
            form.submit();
        }

        function deleteItem(url) {
            if(confirm('Hapus barang ini dari keranjang?')) {
                const form = document.getElementById('action-form');
                form.action = url;
                document.getElementById('form-method').value = 'DELETE';
                form.submit();
            }
        }
    </script>
</x-app-layout>
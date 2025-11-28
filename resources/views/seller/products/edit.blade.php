<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('seller.products.index') }}" class="text-slate-500 hover:text-slate-800 text-sm flex items-center gap-1 transition">
                    <span>←</span> Kembali ke List Produk
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Produk</h1>

                <!-- Error Validation Global -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <strong>Mohon periksa inputan Anda:</strong>
                            <ul class="list-disc list-inside mt-1 ml-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nama Produk -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                            class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400 transition" 
                            placeholder="Contoh: Laptop Gaming ROG Zephyrus">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori & Harga -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                            <select name="category_id" required class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 cursor-pointer">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Harga (Rp)</label>
                            <!-- Validasi HTML: min="1" -->
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="1"
                                class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400 transition" 
                                placeholder="Contoh: 15000000">
                            <p class="text-xs text-slate-400 mt-1">Minimal Rp 1. Tidak boleh 0 atau negatif.</p>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Stok & Gambar -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Stok Saat Ini</label>
                            <!-- Validasi HTML: min="0" (Boleh 0 kalau mau tandai habis, tapi tidak boleh minus) -->
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                                class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400 transition" 
                                placeholder="Contoh: 50">
                            <p class="text-xs text-slate-400 mt-1">Tidak boleh negatif. (0 = Stok Habis)</p>
                            @error('stock')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Ubah Gambar (Opsional)</label>
                            
                            <!-- INPUT FILE SAJA (Tanpa Preview Gambar Lama) -->
                            <input type="file" name="image" accept="image/png, image/jpeg, image/jpg"
                                class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2.5 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-bold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                                border border-slate-300 rounded-xl p-1 cursor-pointer transition">
                            <p class="text-xs text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                            
                            @error('image')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Lengkap</label>
                        <textarea name="description" rows="5" required 
                            class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400 transition resize-none" 
                            placeholder="Jelaskan spesifikasi, keunggulan, dan kondisi produk secara detail...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                        <a href="{{ route('seller.products.index') }}" class="px-6 py-3.5 rounded-xl border border-slate-300 text-slate-600 font-bold hover:bg-slate-50 transition text-sm">
                            Batal
                        </a>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 hover:-translate-y-0.5 active:translate-y-0">
                            Update Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
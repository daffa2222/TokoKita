<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('seller.products.index') }}" class="text-slate-500 hover:text-slate-800 text-sm flex items-center gap-1">
                    ← Kembali ke List Produk
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                <h1 class="text-2xl font-bold text-slate-800 mb-6">Tambah Produk Baru</h1>

                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Nama Produk -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Produk</label>
                        <input type="text" name="name" required class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Laptop Gaming ROG">
                    </div>

                    <!-- Kategori & Harga -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                            <select name="category_id" required class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Harga (Rp)</label>
                            <input type="number" name="price" required class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="0">
                        </div>
                    </div>

                    <!-- Stok & Gambar -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Stok Awal</label>
                            <input type="number" name="stock" required class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="0">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Gambar Produk</label>
                            <input type="file" name="image" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-300 rounded-xl p-1">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Lengkap</label>
                        <textarea name="description" rows="5" required class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Jelaskan detail produkmu..."></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
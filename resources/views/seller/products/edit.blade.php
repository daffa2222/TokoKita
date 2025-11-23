<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('seller.products.index') }}" class="text-slate-500 hover:text-slate-800 text-sm flex items-center gap-1">
                    ← Batal Edit
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Produk: {{ $product->name }}</h1>

                <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Produk</label>
                        <input type="text" name="name" value="{{ $product->name }}" required class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                            <select name="category_id" required class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ $product->price }}" required class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Stok</label>
                            <input type="number" name="stock" value="{{ $product->stock }}" required class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Ubah Gambar (Opsional)</label>
                            <input type="file" name="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-300 rounded-xl p-1">
                            <p class="text-xs text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi</label>
                        <textarea name="description" rows="5" required class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">{{ $product->description }}</textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            Update Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
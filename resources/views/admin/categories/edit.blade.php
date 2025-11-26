<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Tombol Kembali -->
            <div class="mb-6">
                <a href="{{ route('admin.categories.index') }}" class="text-slate-500 hover:text-indigo-600 font-medium text-sm flex items-center gap-1 transition">
                    <span>←</span> Kembali ke Daftar Kategori
                </a>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Kategori</h1>

                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori</label>
                        <input type="text" name="name" value="{{ $category->name }}" required 
                            class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 placeholder-slate-400">
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            Simpan Perubahan
                        </button>
                        
                        <a href="{{ route('admin.categories.index') }}" class="text-slate-500 font-bold hover:text-slate-700 px-4">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
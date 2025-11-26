<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Tombol Kembali -->
            <div class="mb-6">
                <a href="{{ route('seller.dashboard') }}" class="text-slate-500 hover:text-slate-800 text-sm flex items-center gap-1 transition">
                    <span>←</span> Kembali ke Dashboard
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">Pengaturan Toko</h1>
                        <p class="text-slate-500 text-sm">Perbarui informasi toko Anda agar terlihat menarik.</p>
                    </div>
                    <!-- Preview Foto Toko Saat Ini -->
                    @if($store->image)
                        <img src="{{ asset('storage/' . $store->image) }}" class="w-16 h-16 rounded-full object-cover border border-slate-200">
                    @endif
                </div>

                <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nama Toko -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Toko</label>
                        <input type="text" name="name" value="{{ old('name', $store->name) }}" required 
                            class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 placeholder-slate-400">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Toko -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Singkat</label>
                        <textarea name="description" rows="4" class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 placeholder-slate-400" placeholder="Ceritakan tentang toko Anda...">{{ old('description', $store->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto Profil Toko -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Foto Profil Toko (Opsional)</label>
                        <div class="flex items-center gap-4">
                            <input type="file" name="image" class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2.5 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-bold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                                border border-slate-300 rounded-xl p-1 cursor-pointer
                            "/>
                        </div>
                        <p class="text-xs text-slate-400 mt-2">Format: JPG, PNG. Maks: 2MB.</p>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
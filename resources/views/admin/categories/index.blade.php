<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Manajemen Kategori</h1>

            <!-- Form Tambah Kategori -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
                <h3 class="font-bold text-slate-700 mb-4">Tambah Kategori Baru</h3>
                <form action="{{ route('admin.categories.store') }}" method="POST" class="flex gap-4">
                    @csrf
                    <input type="text" name="name" required placeholder="Nama Kategori (misal: Mainan Anak)" 
                        class="flex-grow rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        Simpan
                    </button>
                </form>
            </div>

            <!-- List Kategori -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Nama Kategori</th>
                            <th class="px-6 py-4">Slug</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr class="bg-white border-b border-slate-50 hover:bg-slate-50">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-slate-400 font-mono text-xs">{{ $category->slug }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-4">
                                        <!-- Hapus -->
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
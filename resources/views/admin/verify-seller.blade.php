<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Verifikasi Seller Baru</h1>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Nama Pemilik</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Nama Toko</th>
                            <th class="px-6 py-4">Tanggal Daftar</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sellers as $seller)
                            <tr class="bg-white border-b border-slate-50 hover:bg-slate-50">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $seller->name }}</td>
                                <td class="px-6 py-4">{{ $seller->email }}</td>
                                <td class="px-6 py-4">
                                    @if($seller->store)
                                        <span class="bg-indigo-50 text-indigo-700 px-2 py-1 rounded font-bold text-xs">{{ $seller->store->name }}</span>
                                    @else
                                        <span class="text-slate-400 italic">Belum buat toko</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $seller->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <!-- Tombol Setuju -->
                                        <form action="{{ route('admin.approve.seller', $seller->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-green-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-green-600 transition shadow-lg shadow-green-200">
                                                Setuju
                                            </button>
                                        </form>

                                        <!-- Tombol Tolak -->
                                        <form action="{{ route('admin.reject.seller', $seller->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak seller ini?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-red-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-600 transition shadow-lg shadow-red-200">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                    Tidak ada permintaan seller baru saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
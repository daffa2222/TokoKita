<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Verifikasi Penjual</h1>
                    <p class="text-slate-500 text-sm">Kelola persetujuan pendaftaran penjual TokoKita.</p>
                </div>
            </div>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-indigo-100 border border-indigo-400 text-indigo-700 px-4 py-3 rounded-xl mb-6 relative shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold">Berhasil!</span> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Nama Pemilik</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Nama Toko</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Tanggal Daftar</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sellers as $seller)
                                <tr class="bg-white border-b border-slate-50 hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $seller->name }}</td>
                                    <td class="px-6 py-4">{{ $seller->email }}</td>
                                    <td class="px-6 py-4">
                                        @if($seller->store)
                                            <span class="text-indigo-600 font-medium">{{ $seller->store->name }}</span>
                                        @else
                                            <span class="text-slate-400 italic text-xs">Belum ada toko</span>
                                        @endif
                                    </td>
                                    
                                    <!-- KOLOM STATUS (BARU) -->
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = match($seller->seller_status) {
                                                'approved' => 'bg-green-100 text-green-700 border-green-200',
                                                'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                                'rejected' => 'bg-red-100 text-red-700 border-red-200',
                                                default => 'bg-gray-100 text-gray-700 border-gray-200'
                                            };
                                            
                                            $statusLabel = match($seller->seller_status) {
                                                'approved' => 'Approved',
                                                'pending' => 'Pending',
                                                'rejected' => 'Rejected',
                                                default => '-'
                                            };
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusClasses }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-xs text-slate-500">{{ $seller->created_at->format('d M Y') }}</td>
                                    
                                    <!-- KOLOM AKSI -->
                                    <td class="px-6 py-4 text-center">
                                        @if($seller->seller_status === 'pending')
                                            <!-- Jika Pending, Tampilkan Tombol Aksi -->
                                            <div class="flex justify-center gap-2">
                                                <form action="{{ route('admin.approve.seller', $seller->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-green-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-green-600 transition shadow-md shadow-green-200" title="Setujui">
                                                        Setuju
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.reject.seller', $seller->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak seller ini?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-red-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-600 transition shadow-md shadow-red-200" title="Tolak">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($seller->seller_status === 'approved')
                                            <!-- Jika Approved -->
                                            <span class="text-xs text-green-600 font-medium flex items-center justify-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Aktif
                                            </span>
                                        @elseif($seller->seller_status === 'rejected')
                                            <!-- Jika Rejected -->
                                            <span class="text-xs text-red-500 font-medium">Non-Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-slate-500">
                                        Belum ada pendaftar seller.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
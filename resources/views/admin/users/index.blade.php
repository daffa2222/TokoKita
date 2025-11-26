<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Halaman -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Manajemen Pengguna</h1>
                    <p class="text-slate-500 text-sm">Kelola data Admin, Seller, dan Buyer.</p>
                </div>
                <!-- Tombol Tambah User Baru (Opsional, jika fitur create sudah siap) -->
                <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah User
                </a>
            </div>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-indigo-100 border border-indigo-400 text-indigo-700 px-4 py-3 rounded-xl mb-6 relative shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold">Berhasil!</span> {{ session('success') }}
                </div>
            @endif

            <!-- Tabel User -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Nama</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Status Seller</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="bg-white border-b border-slate-50 hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 font-bold text-slate-900 flex items-center gap-3">
                                        <!-- Avatar Inisial -->
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold border border-indigo-200">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $roleColor = match($user->role) {
                                                'admin' => 'bg-red-100 text-red-700 border-red-200',
                                                'seller' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'buyer' => 'bg-green-100 text-green-700 border-green-200',
                                                default => 'bg-gray-100 text-gray-700'
                                            };
                                        @endphp
                                        <span class="px-2 py-1 rounded text-xs font-bold uppercase border {{ $roleColor }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->role === 'seller')
                                            @php
                                                $statusColor = match($user->seller_status) {
                                                    'approved' => 'text-green-600 font-bold',
                                                    'pending' => 'text-orange-500 font-bold',
                                                    'rejected' => 'text-red-500 font-bold',
                                                    default => 'text-gray-400'
                                                };
                                            @endphp
                                            <span class="{{ $statusColor }} flex items-center gap-1">
                                                @if($user->seller_status == 'approved')  @endif
                                                {{ ucfirst($user->seller_status) }}
                                            </span>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-50 text-yellow-600 px-3 py-1.5 rounded-lg font-bold text-xs hover:bg-yellow-100 border border-yellow-200 transition flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                Edit
                                            </a>

                                            <!-- Tombol Hapus (Cegah hapus diri sendiri) -->
                                            @if($user->id !== Auth::id())
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}? Tindakan ini tidak bisa dibatalkan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-bold text-xs hover:bg-red-100 border border-red-200 transition flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            @else
                                                <span class="px-3 py-1.5 text-xs text-slate-400 italic bg-slate-50 rounded-lg border border-slate-100">Saya</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                        Belum ada pengguna lain.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
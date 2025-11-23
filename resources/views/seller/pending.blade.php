<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="min-h-screen bg-slate-50 flex flex-col justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-2xl border border-slate-100 text-center">
            
            <!-- Ikon Jam Pasir / Menunggu -->
            <div class="w-20 h-20 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>

            <h2 class="text-2xl font-bold text-slate-800 mb-2">Menunggu Persetujuan</h2>
            
            <p class="text-slate-600 mb-6">
                Halo, <strong>{{ Auth::user()->name }}</strong>!<br>
                Pendaftaran toko Anda sedang ditinjau oleh Admin.
            </p>

            <div class="bg-blue-50 text-blue-700 p-4 rounded-xl text-sm mb-6 text-left flex gap-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p>
                    Anda akan mendapatkan akses penuh ke Dashboard Toko setelah Admin menyetujui akun Anda. Silakan cek kembali secara berkala.
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-slate-500 hover:text-slate-800 underline text-sm font-medium">
                    Keluar (Logout)
                </button>
            </form>

            <!-- Tampilkan Tombol Hapus Akun jika Ditolak -->
            @if(Auth::user()->seller_status === 'rejected')
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <p class="text-red-500 font-bold mb-2">Mohon Maaf, Pengajuan Ditolak.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Yakin ingin menghapus akun?');">
                        @csrf
                        @method('delete')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-600">
                            Hapus Akun Saya
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
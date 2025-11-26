<x-app-layout>
    <!-- Font Poppins -->
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="min-h-screen bg-[#F8FAFC] flex flex-col justify-center items-center p-4">
        
        <div class="w-full sm:max-w-md bg-white shadow-2xl shadow-indigo-100/50 rounded-[2.5rem] border border-slate-100 overflow-hidden relative">
            
            <!-- LOGIKA TAMPILAN BERDASARKAN STATUS -->
            
            <!-- KASUS 1: DITOLAK (REJECTED) -->
            @if(Auth::user()->seller_status === 'rejected')
                <div class="absolute top-0 left-0 w-full h-2 bg-red-500"></div>
                
                <div class="p-10 text-center">
                    <!-- Ikon Ditolak -->
                    <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                        <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>

                    <h2 class="text-2xl font-extrabold text-slate-800 mb-2">Mohon Maaf, <br>Pengajuan Ditolak.</h2>
                    
                    <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                        Data toko Anda belum memenuhi kriteria kami. Silakan hapus akun ini dan coba mendaftar kembali dengan data yang valid.
                    </p>

                    <!-- Tombol Hapus Akun -->
                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Yakin ingin menghapus akun permanen?');">
                        @csrf
                        @method('delete')
                        
                        <!-- Password Input Trick (Opsional: Jika controller butuh password, kita bisa minta user input dulu, atau bypass di controller. 
                             Untuk tampilan bersih, biasanya tombol ini memicu modal confirm password. 
                             Disini kita arahkan user ke halaman edit profil untuk hapus mandiri agar aman) -->
                        
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center w-full bg-red-500 text-white px-6 py-3.5 rounded-xl font-bold text-sm hover:bg-red-600 transition shadow-lg shadow-red-200 hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus Akun Saya
                        </a>
                    </form>
                    
                    <div class="mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-slate-400 hover:text-slate-600 text-xs font-medium underline">
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>

            <!-- KASUS 2: MENUNGGU (PENDING) -->
            @else
                <div class="absolute top-0 left-0 w-full h-2 bg-yellow-400"></div>

                <div class="p-10 text-center">
                    <!-- Ikon Jam Pasir -->
                    <div class="w-24 h-24 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                        <svg class="w-10 h-10 text-yellow-500 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <!-- Dekorasi titik -->
                        <span class="absolute top-2 right-4 w-3 h-3 bg-yellow-400 rounded-full animate-ping"></span>
                    </div>

                    <h2 class="text-2xl font-extrabold text-slate-800 mb-2">Menunggu Persetujuan</h2>
                    
                    <div class="inline-block bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-6">
                        Status: Dalam Peninjauan
                    </div>

                    <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                        Halo, <strong>{{ Auth::user()->name }}</strong>!<br>
                        Pendaftaran toko Anda sedang kami proses. Mohon tunggu sebentar, biasanya memakan waktu 1x24 jam.
                    </p>

                    

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-slate-800 text-white px-6 py-3.5 rounded-xl font-bold text-sm hover:bg-slate-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Keluar (Logout)
                        </button>
                    </form>
                </div>
            @endif

        </div>
        
        <!-- Footer kecil -->
        <p class="text-slate-400 text-xs mt-8 text-center">
            &copy; {{ date('Y') }} TokoKita. All rights reserved.
        </p>
    </div>
</x-app-layout>
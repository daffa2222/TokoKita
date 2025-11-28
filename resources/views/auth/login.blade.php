<x-guest-layout>
    <!-- Font Poppins & Custom Style -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Poppins', sans-serif; }
    </style>

    <div class="w-full">
        <!-- Header: Judul & Subjudul -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 mb-6 shadow-sm border border-indigo-100">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
            </div>
            <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Selamat Datang di TokoKita!</h2>
            <p class="text-slate-500 mt-2 text-sm">Masuk untuk mulai belanja atau kelola toko anda.</p>
        </div>

        <!-- Session Status (Pesan Sukses/Error dari Redirect) -->
        <x-auth-session-status class="mb-6" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6" autocomplete="off">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2 ml-1">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    </div>
                    <!-- Value dikosongkan total, autocomplete off -->
                    <input id="email" type="email" name="email" required autofocus autocomplete="new-email" 
                        class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white text-slate-700 text-sm font-medium transition-all placeholder-slate-400" 
                        placeholder="Contoh: nama@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500 font-medium ml-1" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between items-center mb-2 ml-1">
                    <label for="password" class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Kata Sandi</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold transition hover:underline">
                            Lupa Password?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <!-- Value kosong, autocomplete off -->
                    <input id="password" type="password" name="password" required autocomplete="new-password" 
                        class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white text-slate-700 text-sm font-medium transition-all placeholder-slate-400" 
                        placeholder="Masukkan kata sandi Anda">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500 font-medium ml-1" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <label for="remember_me" class="inline-flex items-center group cursor-pointer select-none">
                    <div class="relative flex items-center">
                        <input id="remember_me" type="checkbox" class="peer h-5 w-5 cursor-pointer appearance-none rounded border border-slate-300 shadow transition-all checked:border-indigo-600 checked:bg-indigo-600 hover:shadow-md focus:ring-2 focus:ring-indigo-200" name="remember">
                        <svg class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-3.5 h-3.5 pointer-events-none opacity-0 peer-checked:opacity-100 text-white transition-opacity" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" /></svg>
                    </div>
                    <span class="ml-3 text-sm text-slate-600 font-medium group-hover:text-slate-800 transition">Ingat Saya</span>
                </label>
            </div>

            <!-- Tombol Login -->
            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold py-4 rounded-xl hover:from-indigo-700 hover:to-violet-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 shadow-lg shadow-indigo-200 transform active:scale-[0.98] transition-all duration-200 text-sm tracking-wide">
                MASUK SEKARANG
            </button>

            <!-- Footer Link -->
            <div class="text-center mt-8 pt-6 border-t border-slate-100">
                <p class="text-sm text-slate-500">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:text-indigo-800 hover:underline transition">
                        Daftar Gratis
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
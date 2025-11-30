<x-guest-layout>
    <!-- Font Poppins -->
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="mb-10">
        <h2 class="text-4xl font-bold text-slate-900 mb-3 tracking-tight">Selamat Datang di TokoKita! 👋</h2>
        <p class="text-slate-500 text-base font-medium">Masuk untuk mulai belanja atau kelola toko anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6" autocomplete="off">
        @csrf

        <!-- Email (Input Modern & Bersih) -->
        <div class="group">
            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Alamat Email</label>
            <div class="relative transition-all duration-300 group-focus-within:-translate-y-1">
                <!-- Hapus :value="old('email')" agar benar-benar kosong saat refresh -->
                <!-- Tambahkan autocomplete="off" atau nilai acak untuk mencegah browser autofill -->
                <input id="email" type="email" name="email" required autofocus autocomplete="new-email"
                    class="peer w-full pl-4 pr-12 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-800 text-sm font-medium placeholder-slate-400 focus:bg-white focus:border-indigo-500 focus:ring-0 transition-all shadow-sm hover:bg-white" 
                    placeholder="Contoh: nama@email.com">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 peer-focus:text-indigo-500 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500 font-medium ml-1" />
        </div>

        <!-- Password (Input Modern & Bersih) -->
        <div class="group">
            <div class="flex justify-between items-center mb-2 ml-1">
                <label class="block text-sm font-bold text-slate-700">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition hover:underline decoration-2 underline-offset-4">
                        Lupa Password?
                    </a>
                @endif
            </div>
            <div class="relative transition-all duration-300 group-focus-within:-translate-y-1">
                <!-- autocomplete="new-password" untuk mencegah browser mengisi password -->
                <input id="password" type="password" name="password" required autocomplete="new-password" 
                    class="peer w-full pl-4 pr-12 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-800 text-sm font-medium placeholder-slate-400 focus:bg-white focus:border-indigo-500 focus:ring-0 transition-all shadow-sm hover:bg-white" 
                    placeholder="Masukkan kata sandi Anda">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 peer-focus:text-indigo-500 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500 font-medium ml-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center ml-1">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer select-none">
                <div class="relative flex items-center">
                    <input id="remember_me" type="checkbox" class="peer h-5 w-5 cursor-pointer appearance-none rounded-lg border-2 border-slate-300 shadow-sm transition-all checked:border-indigo-600 checked:bg-indigo-600 hover:border-indigo-400 focus:ring-0" name="remember">
                    <svg class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-3.5 h-3.5 pointer-events-none opacity-0 peer-checked:opacity-100 text-white transition-opacity" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" /></svg>
                </div>
                <span class="ml-3 text-sm text-slate-600 font-medium group-hover:text-slate-900 transition">Ingat saya</span>
            </label>
        </div>

        <!-- Tombol Login -->
        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-2xl hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 shadow-xl shadow-indigo-200/50 transform hover:-translate-y-1 active:scale-[0.98] transition-all duration-300 text-base tracking-wide flex justify-center items-center gap-3 group relative overflow-hidden">
            <span class="relative z-10">Masuk Sekarang</span>
            <svg class="w-5 h-5 relative z-10 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            <!-- Efek Kilau -->
            <div class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/10"></div>
        </button>

        <!-- Footer -->
        <div class="text-center mt-10 pt-6 border-t border-slate-100">
            <p class="text-sm text-slate-500 font-medium">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:text-indigo-800 transition hover:underline decoration-2 underline-offset-4 ml-1">
                    Daftar Gratis
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
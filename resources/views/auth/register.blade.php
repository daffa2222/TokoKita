<x-guest-layout>
    <!-- Font Poppins -->
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900 mb-3 tracking-tight">Mulai Perjalananmu 🚀</h2>
        <p class="text-slate-500 text-base font-medium">Isi data di bawah untuk bergabung dengan TokoKita.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" autocomplete="off">
        @csrf

        <!-- Nama -->
        <div class="group">
            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nama Lengkap</label>
            <div class="relative transition-all duration-300 group-focus-within:-translate-y-1">
                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                    class="peer w-full pl-4 pr-12 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-800 text-sm font-medium placeholder-slate-400 focus:bg-white focus:border-indigo-500 focus:ring-0 transition-all shadow-sm hover:bg-white"
                    placeholder="Contoh: Budi Santoso">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 peer-focus:text-indigo-500 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-500 font-medium ml-1" />
        </div>

        <!-- Email -->
        <div class="group">
            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Email</label>
            <div class="relative transition-all duration-300 group-focus-within:-translate-y-1">
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                    class="peer w-full pl-4 pr-12 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-800 text-sm font-medium placeholder-slate-400 focus:bg-white focus:border-indigo-500 focus:ring-0 transition-all shadow-sm hover:bg-white"
                    placeholder="nama@email.com">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 peer-focus:text-indigo-500 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500 font-medium ml-1" />
        </div>

        <!-- Role Selection (Card Style) -->
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-3 ml-1">Daftar Sebagai</label>
            <div class="grid grid-cols-2 gap-4">
                <!-- Buyer -->
                <label class="cursor-pointer group relative">
                    <input type="radio" name="role" value="buyer" class="peer sr-only" checked>
                    <div class="p-4 rounded-2xl border-2 border-slate-100 bg-white hover:border-indigo-300 hover:shadow-md transition-all peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:shadow-lg relative overflow-hidden h-full flex flex-col items-center justify-center text-center gap-2">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 shadow-sm peer-checked:bg-indigo-600 peer-checked:text-white transition-colors mb-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-700 peer-checked:text-indigo-800 transition-colors">Pembeli</span>
                        <span class="text-[10px] text-slate-400 peer-checked:text-indigo-500 font-medium">Belanja Sepuasnya</span>
                    </div>
                    <!-- Checkmark -->
                    <div class="absolute top-3 right-3 w-6 h-6 bg-indigo-600 rounded-full text-white flex items-center justify-center opacity-0 scale-0 peer-checked:opacity-100 peer-checked:scale-100 transition-all z-20 shadow-sm border-2 border-white">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </label>

                <!-- Seller -->
                <label class="cursor-pointer group relative">
                    <input type="radio" name="role" value="seller" class="peer sr-only">
                    <div class="p-4 rounded-2xl border-2 border-slate-100 bg-white hover:border-indigo-300 hover:shadow-md transition-all peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:shadow-lg relative overflow-hidden h-full flex flex-col items-center justify-center text-center gap-2">
                        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 shadow-sm peer-checked:bg-indigo-600 peer-checked:text-white transition-colors mb-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-700 peer-checked:text-indigo-800 transition-colors">Penjual</span>
                        <span class="text-[10px] text-slate-400 peer-checked:text-indigo-500 font-medium">Buka Toko Sendiri</span>
                    </div>
                    <!-- Checkmark -->
                    <div class="absolute top-3 right-3 w-6 h-6 bg-indigo-600 rounded-full text-white flex items-center justify-center opacity-0 scale-0 peer-checked:opacity-100 peer-checked:scale-100 transition-all z-20 shadow-sm border-2 border-white">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </label>
            </div>
        </div>

        <!-- Password Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="group">
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Kata Sandi</label>
                <div class="relative transition-all duration-300 group-focus-within:-translate-y-1">
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="peer w-full pl-4 pr-12 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-800 text-sm font-medium placeholder-slate-400 focus:bg-white focus:border-indigo-500 focus:ring-0 transition-all shadow-sm hover:bg-white"
                        placeholder="Min. 8 karakter">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 peer-focus:text-indigo-500 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                </div>
            </div>
            <div class="group">
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Ulangi Sandi</label>
                <div class="relative transition-all duration-300 group-focus-within:-translate-y-1">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="peer w-full pl-4 pr-12 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-800 text-sm font-medium placeholder-slate-400 focus:bg-white focus:border-indigo-500 focus:ring-0 transition-all shadow-sm hover:bg-white"
                        placeholder="Ketik ulang">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 peer-focus:text-indigo-500 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
            </div>
        </div>
        <x-input-error :messages="$errors->get('password')" class="text-xs text-red-500 ml-1 font-medium" />

        <!-- Submit -->
        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-2xl hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 shadow-xl shadow-indigo-200/50 transform active:scale-[0.98] transition-all duration-200 text-base tracking-wide flex justify-center items-center gap-2 group relative overflow-hidden">
            <span class="relative z-10">Daftar Sekarang</span>
            <svg class="w-5 h-5 relative z-10 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            <div class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/10"></div>
        </button>

        <div class="text-center mt-10 pt-6 border-t border-slate-100">
            <p class="text-sm text-slate-500 font-medium">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:text-indigo-800 transition hover:underline decoration-2 underline-offset-4 ml-1">Masuk Disini</a>
            </p>
        </div>
    </form>
</x-guest-layout>
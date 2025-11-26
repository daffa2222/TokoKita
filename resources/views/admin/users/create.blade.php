<x-app-layout>
    <!-- Font Poppins -->
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Tombol Kembali -->
            <div class="mb-6">
                <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-800 text-sm flex items-center gap-1 transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Pengguna
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-10">
                
                <!-- Header Form -->
                <div class="mb-8 pb-6 border-b border-slate-100">
                    <h1 class="text-2xl font-bold text-slate-800">Tambah Pengguna Baru</h1>
                    <p class="text-slate-500 text-sm mt-1">Buat akun manual untuk Admin, Seller, atau Buyer baru.</p>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6" autocomplete="off">
                    @csrf
                    
                    <!-- 1. Identitas Dasar -->
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Nama -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Nama Lengkap</label>
                            <!-- Value hanya diisi old('name') agar kosong saat pertama buka, tapi tetap ada isinya jika submit gagal -->
                            <input type="text" name="name" value="{{ old('name') }}" required 
                                class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 py-3 px-4 transition shadow-sm placeholder-slate-400"
                                placeholder="Contoh: Budi Santoso" autocomplete="off">
                            @error('name') <p class="text-red-500 text-xs mt-1 font-medium ml-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required 
                                class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 py-3 px-4 transition shadow-sm placeholder-slate-400"
                                placeholder="Contoh: budi@email.com" autocomplete="new-email">
                            @error('email') <p class="text-red-500 text-xs mt-1 font-medium ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- 2. Peran Pengguna -->
                    <div class="p-5 bg-indigo-50 rounded-2xl border border-indigo-100">
                        <label class="block text-xs font-bold text-indigo-800 uppercase tracking-wider mb-2 ml-1">Peran (Role)</label>
                        <div class="relative">
                            <select name="role" class="w-full rounded-xl border-indigo-200 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 cursor-pointer appearance-none py-3 pl-4 pr-10 shadow-sm bg-white">
                                <option value="" disabled selected>Pilih Peran Pengguna...</option>
                                <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>Buyer (Pembeli)</option>
                                <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>Seller (Penjual)</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-indigo-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        
                        @error('role') <p class="text-red-500 text-xs mt-1 font-medium ml-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- 3. Keamanan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 ml-1">Keamanan Akun</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <input type="password" name="password" required 
                                    class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 py-3 px-4 transition shadow-sm placeholder-slate-400"
                                    placeholder="Password (Min. 8 karakter)" autocomplete="new-password">
                                @error('password') <p class="text-red-500 text-xs mt-1 font-medium ml-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <input type="password" name="password_confirmation" required 
                                    class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 py-3 px-4 transition shadow-sm placeholder-slate-400"
                                    placeholder="Ulangi Password yang sama" autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-4">
                        <a href="{{ route('admin.users.index') }}" class="text-slate-500 font-bold text-sm hover:text-slate-800 transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5 active:scale-95 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            Buat Akun Baru
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
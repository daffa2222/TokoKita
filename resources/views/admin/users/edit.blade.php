<x-app-layout>
    <!-- Font Poppins -->
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Tombol Kembali -->
            <div class="mb-6">
                <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-800 text-sm flex items-center gap-1 transition">
                    <span>←</span> Kembali ke Daftar Pengguna
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                <div class="mb-8 border-b border-slate-100 pb-4">
                    <h1 class="text-2xl font-bold text-slate-800">Edit Data Pengguna</h1>
                    <p class="text-slate-500 text-sm mt-1">Ubah informasi profil, peran, atau reset password pengguna.</p>
                </div>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- 1. IDENTITAS PENGGUNA -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 shadow-sm placeholder-slate-400">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 shadow-sm placeholder-slate-400">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- 2. PERAN & AKSES -->
                    <div class="p-5 bg-indigo-50 rounded-xl border border-indigo-100">
                        <label class="block text-sm font-bold text-indigo-900 mb-2">Peran (Role)</label>
                        <div class="relative">
                            <select name="role" class="w-full rounded-xl border-indigo-200 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 shadow-sm cursor-pointer appearance-none py-3 pl-4 pr-10">
                                <option value="buyer" {{ $user->role == 'buyer' ? 'selected' : '' }}>Buyer (Pembeli)</option>
                                <option value="seller" {{ $user->role == 'seller' ? 'selected' : '' }}>Seller (Penjual)</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (Pengelola)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-indigo-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <p class="text-xs text-indigo-500 mt-2 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            *Jika diubah menjadi Seller, toko akan otomatis dibuatkan.
                        </p>

                        <!-- Jika User adalah Seller, Admin bisa ubah nama tokonya -->
                        @if($user->role === 'seller' && $user->store)
                            <div class="mt-4 pt-4 border-t border-indigo-200">
                                <label class="block text-xs font-bold text-indigo-800 uppercase tracking-wider mb-2">Nama Toko (Khusus Seller)</label>
                                <input type="text" name="store_name" value="{{ old('store_name', $user->store->name) }}" 
                                    class="w-full rounded-xl border-indigo-200 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 placeholder-indigo-300">
                                <p class="text-xs text-indigo-400 mt-1">Ubah nama toko pengguna ini jika tidak sesuai.</p>
                            </div>
                        @endif
                    </div>

                    <!-- 3. KEAMANAN (PASSWORD) -->
                    <div class="p-5 bg-red-50 rounded-xl border border-red-100">
                        <h3 class="font-bold text-red-800 text-sm mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Reset Password (Opsional)
                        </h3>
                        <p class="text-xs text-red-600 mb-4">Isi kolom di bawah HANYA JIKA Anda ingin mengubah password pengguna ini. Jika tidak, biarkan kosong.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-2">Password Baru</label>
                                <input type="password" name="password" 
                                    class="w-full rounded-xl border-slate-300 focus:ring-red-500 focus:border-red-500 text-slate-700 placeholder-slate-400"
                                    placeholder="Minimal 8 karakter">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-2">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" 
                                    class="w-full rounded-xl border-slate-300 focus:ring-red-500 focus:border-red-500 text-slate-700 placeholder-slate-400"
                                    placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                        <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 rounded-xl border border-slate-300 text-slate-600 font-bold hover:bg-slate-50 transition text-sm">
                            Batal
                        </a>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5 text-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
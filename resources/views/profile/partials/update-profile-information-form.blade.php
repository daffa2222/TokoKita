<section>
    <!-- Font Poppins -->
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <header>
        <h2 class="text-lg font-bold text-slate-800">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Nama -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-bold" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-bold" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-slate-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-indigo-600 hover:text-indigo-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- ALAMAT PENGIRIMAN (Hanya Tampil untuk Buyer) -->
        <!-- Admin dan Seller tidak butuh kolom ini di profil mereka -->
        @if($user->role === 'buyer') 
        <div>
            <x-input-label for="address" :value="__('Alamat Pengiriman Default')" class="text-slate-700 font-bold" />
            <textarea id="address" name="address" rows="3" 
                class="mt-1 block w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm placeholder-slate-400 text-slate-700 resize-none transition" 
                placeholder="Contoh: Jl. Merdeka No. 45, Jakarta Pusat">{{ old('address', $user->address) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
            <p class="text-xs text-slate-500 mt-1 ml-1">Alamat ini akan otomatis terisi saat Anda melakukan checkout.</p>
        </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 focus:ring-indigo-500 rounded-xl px-6 py-2.5 font-bold transition shadow-lg shadow-indigo-200">
                {{ __('Simpan Perubahan') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-bold flex items-center gap-1 bg-green-50 px-3 py-1 rounded-lg border border-green-200"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Berhasil Disimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>
<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            
            <!-- LOGO AREA -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="bg-gradient-to-br from-indigo-600 to-violet-600 text-white p-2.5 rounded-xl shadow-lg shadow-indigo-200 group-hover:scale-105 transition transform duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-700 to-violet-700 tracking-tight">TokoKita</span>
                </a>
            </div>

            <!-- DESKTOP MENU -->
            <div class="hidden sm:flex items-center gap-1">
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="px-4 py-2 rounded-full text-sm font-medium transition hover:bg-indigo-50 hover:text-indigo-600 border-0 text-slate-600">
                    {{ __('Beranda') }}
                </x-nav-link>

                @auth
                    <!-- ROLE: BUYER -->
                    @if(Auth::user()->role === 'buyer')
                        <x-nav-link :href="route('buyer.cart')" :active="request()->routeIs('buyer.cart')" class="px-4 py-2 rounded-full text-sm font-medium transition hover:bg-indigo-50 hover:text-indigo-600 border-0 relative text-slate-600">
                            {{ __('Keranjang') }}
                        </x-nav-link>
                        
                        <!-- PERHATIKAN INI: route('buyer.wishlist.index') -->
                        <x-nav-link :href="route('buyer.wishlist.index')" :active="request()->routeIs('buyer.wishlist.index')" class="px-4 py-2 rounded-full text-sm font-medium transition hover:bg-red-50 hover:text-red-600 border-0 text-slate-600">
                            Favorit ❤️
                        </x-nav-link>
                        
                        <x-nav-link :href="route('buyer.orders')" :active="request()->routeIs('buyer.orders')" class="px-4 py-2 rounded-full text-sm font-medium transition hover:bg-indigo-50 hover:text-indigo-600 border-0 text-slate-600">
                            {{ __('Transaksi') }}
                        </x-nav-link>
                    @endif

                    <!-- ROLE: ADMIN -->
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="ml-2 px-5 py-2 text-sm font-bold text-white bg-slate-800 rounded-full hover:bg-slate-700 transition shadow-md flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Admin Panel
                        </a>
                    @endif

                    <!-- ROLE: SELLER -->
                    @if(Auth::user()->role === 'seller')
                        <a href="{{ route('seller.dashboard') }}" class="ml-2 px-5 py-2 text-sm font-bold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition shadow-md shadow-indigo-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Toko Saya
                        </a>
                    @endif
                @endauth
            </div>

            <!-- USER DROPDOWN (KANAN) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 px-3 py-2 rounded-full bg-white border border-slate-200 hover:border-indigo-300 hover:shadow-sm transition group">
                                <!-- Avatar Otomatis (Inisial) -->
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=ffffff&size=128" 
                                     class="w-8 h-8 rounded-full object-cover border border-indigo-100">
                                
                                <span class="text-sm font-medium text-slate-700 group-hover:text-indigo-700 max-w-[100px] truncate">
                                    {{ Auth::user()->name }}
                                </span>
                                
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Info Role -->
                            <div class="px-4 py-3 border-b border-slate-100 bg-slate-50">
                                <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Login Sebagai</p>
                                <p class="text-sm font-bold text-indigo-600">{{ ucfirst(Auth::user()->role) }}</p>
                            </div>

                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ __('Pengaturan Akun') }}
                            </x-dropdown-link>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:bg-red-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transform hover:-translate-y-0.5">Daftar Sekarang</a>
                    </div>
                @endauth
            </div>
            
            <!-- MOBILE HAMBURGER (Tetap Simple) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- MOBILE MENU (Responsive) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b border-slate-100 shadow-lg">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">Beranda</x-responsive-nav-link>
            
            @auth
                @if(Auth::user()->role === 'buyer')
                    <x-responsive-nav-link :href="route('buyer.cart')" :active="request()->routeIs('buyer.cart')">Keranjang</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('buyer.orders')" :active="request()->routeIs('buyer.orders')">Transaksi</x-responsive-nav-link>
                    <!-- PERBAIKAN JUGA UNTUK MENU MOBILE -->
                    <x-responsive-nav-link :href="route('buyer.wishlist.index')" :active="request()->routeIs('buyer.wishlist.index')">Favorit ❤️</x-responsive-nav-link>
                @endif

                @if(Auth::user()->role === 'seller')
                    <x-responsive-nav-link :href="route('seller.dashboard')" :active="request()->routeIs('seller.dashboard')">Dashboard Toko</x-responsive-nav-link>
                @endif

                @if(Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Admin Panel</x-responsive-nav-link>
                @endif
            @else
                <div class="border-t border-slate-100 pt-2 mt-2">
                    <x-responsive-nav-link :href="route('login')">Masuk</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">Daftar</x-responsive-nav-link>
                </div>
            @endauth
        </div>

        <!-- Mobile User Info -->
        @auth
            <div class="pt-4 pb-4 border-t border-slate-100 bg-slate-50">
                <div class="px-4 flex items-center gap-3">
                    <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="text-xs font-bold text-indigo-600 uppercase border border-indigo-200 px-2 py-0.5 rounded-md">{{ Auth::user()->role }}</div>
                </div>
                <div class="mt-3 space-y-1 px-4">
                    <x-responsive-nav-link :href="route('profile.edit')">{{ __('Pengaturan Akun') }}</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                            {{ __('Keluar') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
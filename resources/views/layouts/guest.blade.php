<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'TokoKita') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Poppins', sans-serif; }
            /* Custom Scrollbar */
            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: #f1f5f9; }
            ::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 10px; }
            ::-webkit-scrollbar-thumb:hover { background: #818cf8; }
        </style>
    </head>
    <body class="font-sans text-slate-900 antialiased bg-white">
        <div class="min-h-screen flex flex-col lg:flex-row">
            
            <!-- BAGIAN KIRI: GAMBAR & QUOTE (Hanya tampil di layar besar) -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-indigo-900 text-white flex-col justify-between p-12 overflow-hidden">
                <!-- Background Image dengan Overlay -->
                <div class="absolute inset-0">
                    <!-- Menggunakan gambar ilustrasi ikon belanja -->
                    <img src="https://img.freepik.com/free-vector/hand-drawn-shopping-pattern-design_23-2149659806.jpg?w=1380&t=st=1709625000~exp=1709625600~hmac=e5b8d0e8d8f8f8f8f8f8f8f8f8f8f8f8f8f8f8f8f8f8f8f8f8f8f8f8f8f8" 
                         class="w-full h-full object-cover opacity-20 mix-blend-overlay" 
                         alt="Shopping Icons Pattern">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/95 via-indigo-800/90 to-purple-900/90"></div>
                </div>

                <!-- Konten Kiri -->
                <div class="relative z-10 pt-10">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <span class="font-bold text-2xl tracking-wide text-white">TokoKita</span>
                    </div>
                </div>

                <div class="relative z-10 mb-10">
                    <h2 class="text-5xl font-bold leading-tight mb-6 tracking-tight">
                        Gaya Hidup <br>
                        <span class="text-indigo-300">Tanpa Batas.</span>
                    </h2>
                    <p class="text-indigo-100 text-lg max-w-md leading-relaxed font-light opacity-90">
                        Temukan koleksi eksklusif dan nikmati pengalaman belanja online yang aman, nyaman, dan penuh inspirasi.
                    </p>
                </div>
                
                <div class="relative z-10 text-xs text-indigo-300/60 font-mono">
                    © {{ date('Y') }} TokoKita Inc. All rights reserved.
                </div>

                <!-- Dekorasi Lingkaran -->
                <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-[-10%] left-[-10%] w-80 h-80 bg-purple-500/20 rounded-full blur-3xl"></div>
            </div>

            <!-- BAGIAN KANAN: FORMULIR -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-16 bg-white relative">
                <div class="w-full max-w-md relative z-10">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>
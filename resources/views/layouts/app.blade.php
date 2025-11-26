<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TokoKita') }}</title>

        <!-- Fonts: Poppins (Global Load) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <style>
            /* Paksa seluruh elemen menggunakan Poppins */
            body, button, input, select, textarea {
                font-family: 'Poppins', sans-serif !important;
            }
            /* Smooth Scrolling untuk pengalaman pengguna yang lebih halus */
            html { scroll-behavior: smooth; }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#F8FAFC] text-slate-800">
        <div class="min-h-screen flex flex-col">
            
            <!-- Navigasi Utama -->
            @include('layouts.navigation')

            <!-- Page Heading (Judul Halaman - Opsional) -->
            @if (isset($header))
                <header class="bg-white shadow-sm border-b border-slate-100 relative z-10">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content (Isi Halaman) -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <!-- Footer (Kaki Halaman - Diperbarui) -->
            <footer class="bg-white border-t border-slate-200 py-8 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col items-center justify-center text-center">
                      
                        <!-- Copyright -->
                        <p class="text-slate-500 text-sm">&copy; {{ date('Y') }} TokoKita. All rights reserved.</p>
                    </div>
                </div>
            </footer>

        </div>
    </body>
</html>
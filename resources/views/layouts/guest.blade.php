<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TokoKita') }}</title>

        <!-- Fonts Poppins (Global) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <style>
            body { font-family: 'Poppins', sans-serif; }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="text-slate-900 antialiased">
        <!-- Background Estetik -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8fafc]">
            
            <!-- Logo Laravel DIHAPUS dari sini -->
            
            <!-- Kartu Form -->
            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-xl shadow-slate-200/50 overflow-hidden sm:rounded-3xl border border-slate-100">
                <!-- Slot untuk konten Login/Register -->
                {{ $slot }}
            </div>

            <!-- Footer Kecil (Opsional) -->
            <div class="mt-8 text-slate-400 text-xs">
                &copy; {{ date('Y') }} TokoKita. All rights reserved.
            </div>
        </div>
    </body>
</html>
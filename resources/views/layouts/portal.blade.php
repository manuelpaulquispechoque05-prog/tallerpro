<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mi cuenta') — {{ config('app.name', 'Taller Pro') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#0a0a0a] text-gray-100 min-h-screen">

    <!-- Navbar simple -->
    <nav class="sticky top-0 z-30 border-b border-white/[0.06] bg-[#0a0a0a]/80 backdrop-blur-xl">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('portal.inicio') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="text-base font-bold text-white">Taller <span class="text-blue-400">Pro</span></span>
                </a>

                <div class="flex items-center gap-3">
                    <a href="{{ route('portal.inicio') }}" class="text-sm text-gray-400 hover:text-white transition">Inicio</a>
                    <a href="{{ route('portal.vehiculos.index') }}" class="text-sm text-gray-400 hover:text-white transition">Mis vehiculos</a>
                    <a href="#" class="text-sm text-gray-400 hover:text-white transition">Mis citas</a>
                    <a href="#" class="text-sm text-gray-400 hover:text-white transition">Mis ordenes</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-gray-400 hover:text-white transition">Cerrar sesion</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
        @yield('content')
    </main>

</body>
</html>

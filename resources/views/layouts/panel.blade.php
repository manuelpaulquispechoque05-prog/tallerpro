<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="theme()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name', 'Taller Pro') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        .glass { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        .glass-card { background: rgba(255,255,255,0.04); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.06); }
        .glass-card:hover { background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.1); }
        .glass-sidebar { background: rgba(10,10,10,0.85); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); }
        .glass-nav { background: rgba(10,10,10,0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        .animate-in { animation: fadeInUp 0.6s ease-out forwards; opacity: 0; }
        .animate-in-d1 { animation-delay: 0.05s; }
        .animate-in-d2 { animation-delay: 0.1s; }
        .animate-in-d3 { animation-delay: 0.15s; }
        .animate-in-d4 { animation-delay: 0.2s; }
        .animate-in-d5 { animation-delay: 0.3s; }
        .animate-in-d6 { animation-delay: 0.4s; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .nav-item { transition: all 0.2s ease; position: relative; }
        .nav-item:hover { transform: translateX(3px); }
        .nav-item-active::before { content: ''; position: absolute; left: -12px; top: 50%; transform: translateY(-50%); width: 3px; height: 20px; background: linear-gradient(to bottom, #3b82f6, #60a5fa); border-radius: 0 3px 3px 0; }
    </style>
</head>
<body class="font-sans antialiased bg-[#0a0a0a] text-gray-100">

    <!-- Mobile overlay -->
    <div x-show="sidebarOpen" @@click="sidebarOpen = false" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 z-40 bg-black/60 lg:hidden"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside class="fixed top-0 left-0 z-50 h-screen w-64 lg:w-64 sidebar-transition flex flex-col border-r border-white/[0.06] glass-sidebar"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
        
        <!-- Logo area -->
        <div class="flex items-center justify-between h-16 px-5 border-b border-white/[0.06] shrink-0">
            <a href="{{ route('panel.dashboard') }}" class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:scale-105 transition-transform">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="text-base font-bold text-white tracking-tight">Taller <span class="text-blue-400">Pro</span></span>
            </a>
            <button @@click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg hover:bg-white/10 transition">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-0.5">
            <div class="text-[10px] font-semibold uppercase tracking-[0.15em] text-gray-600 px-3 pb-2">Menu principal</div>
            
            @php
                $navItems = [
                    ['route' => 'panel.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['route' => 'panel.clientes.index', 'label' => 'Clientes', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                    ['route' => 'panel.vehiculos.index', 'label' => 'Vehiculos', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    ['route' => 'panel.ordenes.index', 'label' => 'Ordenes', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ['route' => 'panel.citas.index', 'label' => 'Citas', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['route' => 'panel.inventario.index', 'label' => 'Inventario', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                    ['route' => 'panel.repuestos.index', 'label' => 'Repuestos', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                    ['route' => 'panel.categorias.index', 'label' => 'Categorias', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                    ['route' => 'panel.proveedores.index', 'label' => 'Proveedores', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                    ['route' => 'panel.especialidades.index', 'label' => 'Especialidades', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                    ['route' => 'panel.mecanicos.index', 'label' => 'Mecanicos', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
                    ['route' => 'panel.sucursales.index', 'label' => 'Sucursales', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ];
            @endphp

            @foreach($navItems as $item)
                @php
                    $routeName = $item['route'] === '#' ? '' : $item['route'];
                    $isActive = $routeName ? request()->routeIs($routeName) || request()->routeIs($routeName . '.*') : false;
                @endphp
                <a href="{{ $routeName ? route($routeName) : '#' }}" 
                   class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group"
                   :class="$isActive ? 'bg-blue-500/10 text-blue-400 nav-item-active' : 'text-gray-400 hover:text-gray-200 hover:bg-white/[0.04]'">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}"/></svg>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach

            <div class="my-5 border-t border-white/[0.06]"></div>
            <div class="text-[10px] font-semibold uppercase tracking-[0.15em] text-gray-600 px-3 pb-2">Sistema</div>

            <a href="#" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-gray-200 hover:bg-white/[0.04] transition-all duration-200 group">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                <span>Configuracion</span>
            </a>
            <a href="/" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-gray-200 hover:bg-white/[0.04] transition-all duration-200 group">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Ir al Portal</span>
            </a>
        </nav>

        <!-- User footer -->
        <div class="p-3 border-t border-white/[0.06] shrink-0">
            <div x-data="{ open: false }" class="relative">
                <button @@click="open = !open" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm transition-all hover:bg-white/[0.04]">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-xs font-bold shadow-lg shadow-blue-500/20">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex-1 text-left">
                        <p class="text-sm font-medium text-gray-200 leading-tight truncate max-w-[120px]">{{ Auth::user()->name ?? 'Usuario' }}</p>
                        <p class="text-xs text-gray-500 truncate max-w-[120px]">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                    <svg class="w-3.5 h-3.5 text-gray-500 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" @@click.away="open = false" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="absolute bottom-full left-0 right-0 mb-2 rounded-xl bg-[#1a1a1a] border border-white/[0.06] shadow-2xl py-1 overflow-hidden">
                            <a href="{{ route('panel.perfil') }}" class="block px-4 py-2.5 text-sm text-gray-300 hover:bg-white/[0.04] transition">Mi perfil</a>
                    <hr class="border-white/[0.06]">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-white/[0.04] transition">Cerrar sesion</button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="lg:ml-64 flex flex-col min-h-screen">
        <!-- Navbar -->
        <header class="sticky top-0 z-30 glass-nav border-b border-white/[0.06]">
            <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                <div class="flex items-center gap-3">
                    <button @@click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-white/10 transition text-gray-400 lg:hidden">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 bg-gradient-to-br from-blue-500/20 to-blue-600/20 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <h1 class="text-sm font-semibold text-gray-100">@yield('title', 'Dashboard')</h1>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <!-- Search -->
                    <button class="p-2 rounded-lg hover:bg-white/10 transition text-white hidden sm:block">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                    <!-- Theme toggle -->
                    <button @@click="toggleDark()" class="p-2 rounded-lg hover:bg-white/10 transition text-white">
                        <svg x-show="!dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M6.343 6.343h12.728"/></svg>
                    </button>
                    <!-- Notifications -->
                    <button class="p-2 rounded-lg hover:bg-white/10 transition text-white relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                    </button>
                    <!-- Avatar -->
                    <div x-data="{ open: false }" class="relative hidden sm:block">
                        <button @@click="open = !open" @@click.away="open = false" class="flex items-center gap-2 pl-3 pr-2 py-1.5 rounded-xl hover:bg-white/[0.04] transition">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-xs font-bold">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</div>
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="absolute right-0 mt-2 w-56 rounded-xl bg-[#1a1a1a] border border-white/[0.06] shadow-2xl py-1 overflow-hidden">
                    <a href="{{ route('panel.perfil') }}" class="block px-4 py-2.5 text-sm text-gray-300 hover:bg-white/[0.04] transition">Mi perfil</a>
                            <hr class="border-white/[0.06]">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-white/[0.04] transition">Cerrar sesion</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 lg:p-6 lg:pt-7">
            @yield('content')
        </main>
    </div>

    <script>
        function theme() {
            const stored = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = stored ? stored === 'dark' : true; // default: dark
            if (isDark) document.documentElement.classList.add('dark');
            return {
                dark: isDark,
                sidebarOpen: false,
                toggleDark() {
                    this.dark = !this.dark;
                    localStorage.setItem('theme', this.dark ? 'dark' : 'light');
                    document.documentElement.classList.toggle('dark');
                }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>

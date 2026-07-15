<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'Taller Pro')); ?></title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        .hero-slide { transition: opacity 1.2s ease-in-out, transform 1.2s ease-in-out; }
        .service-card { transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .service-card:hover .service-img { transform: scale(1.08); }
        .service-card:hover .service-overlay { opacity: 0.7; }
        .service-card:hover .service-glass { transform: translateY(-6px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); }
        .service-img { transition: transform 0.7s ease; }
        .service-glass { transition: all 0.4s ease; }
        .fade-in { opacity: 0; transform: translateY(40px); transition: opacity 0.8s ease-out, transform 0.8s ease-out; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        .float-anim { animation: float 4s ease-in-out infinite; }
    </style>
</head>
<body class="font-sans antialiased bg-[#0a0a0a]">

<!-- ========== NAVBAR ========== -->
<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = window.scrollY > 60"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
     :class="scrolled ? 'bg-[#0a0a0a]/90 backdrop-blur-xl shadow-2xl shadow-black/20' : 'bg-transparent'">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="text-xl font-bold text-white tracking-tight">Taller <span class="text-blue-400">Pro</span></span>
            </a>

            <div class="hidden md:flex items-center gap-10">
                <a href="#inicio" class="text-sm font-medium text-gray-300 hover:text-white transition-colors relative group">Inicio<span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-400 transition-all duration-300 group-hover:w-full"></span></a>
                <a href="#servicios" class="text-sm font-medium text-gray-300 hover:text-white transition-colors relative group">Servicios<span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-400 transition-all duration-300 group-hover:w-full"></span></a>
                <a href="#nosotros" class="text-sm font-medium text-gray-300 hover:text-white transition-colors relative group">Nosotros<span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-400 transition-all duration-300 group-hover:w-full"></span></a>
                <a href="#contacto" class="text-sm font-medium text-gray-300 hover:text-white transition-colors relative group">Contacto<span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-400 transition-all duration-300 group-hover:w-full"></span></a>
            </div>

            <div class="hidden md:flex items-center gap-4">
                <?php if(Route::has('login')): ?>
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('panel.dashboard')); ?>" class="inline-flex items-center text-sm font-medium text-gray-300 hover:text-white transition gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Dashboard
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-gray-300 hover:text-white transition">Iniciar sesion</a>
                    <?php endif; ?>
                <?php endif; ?>
                <a href="#" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40">Reservar cita<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
            </div>

            <button @click="open = !open" class="md:hidden p-2 rounded-lg hover:bg-white/10 transition">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'inline-flex': open, 'hidden': !open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="md:hidden bg-[#0a0a0a]/95 backdrop-blur-xl border-t border-white/10">
        <div class="px-6 py-6 space-y-4">
            <a href="#inicio" @click="open = false" class="block text-white font-medium">Inicio</a>
            <a href="#servicios" @click="open = false" class="block text-gray-300">Servicios</a>
            <a href="#nosotros" @click="open = false" class="block text-gray-300">Nosotros</a>
            <a href="#contacto" @click="open = false" class="block text-gray-300">Contacto</a>
            <hr class="border-white/10">
            <?php if(Route::has('login')): ?>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('panel.dashboard')); ?>" class="block text-blue-400 font-medium">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="block text-gray-300">Iniciar sesion</a>
                <?php endif; ?>
            <?php endif; ?>
            <a href="#" class="block w-full text-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold rounded-full">Reservar cita</a>
        </div>
    </div>
</nav>

<!-- ========== HERO SLIDER ========== -->
<section id="inicio" class="relative h-screen overflow-hidden bg-black">
    <div x-data="{ 
        slides: [
            { img: '<?php echo e(asset('images/hero/car.png')); ?>', tag: 'Servicio profesional',       title: 'El mejor cuidado para tu vehiculo',           desc: 'Diagnostico computarizado, mecanicos certificados y repuestos originales.',  cta: 'Reservar cita' },
            { img: '<?php echo e(asset('images/hero/car2.png')); ?>', tag: 'Diagnostico de precision',   title: 'Tu vehiculo merece atencion de expertos',    desc: 'Agenda un diagnostico completo y recibe un presupuesto sin compromiso.',       cta: 'Agendar diagnostico' },
            { img: '<?php echo e(asset('images/hero/moto.png')); ?>', tag: 'Taller multiplataforma',      title: 'Servicio para autos y motos',                desc: 'Cubrimos todo tipo de vehiculos con el mismo nivel de calidad y garantia.',   cta: 'Ver servicios' },
            { img: '<?php echo e(asset('images/hero/moto2.png')); ?>',tag: 'Mantenimiento preventivo',    title: 'Preven antes que reparar',                   desc: 'Mantenimiento periodico para alargar la vida util de tu vehiculo.',           cta: 'Agendar mantenimiento' },
            { img: '<?php echo e(asset('images/hero/moto3.png')); ?>',tag: 'Repuestos originales',        title: 'Calidad que se siente',                      desc: 'Solo trabajamos con repuestos originales y de las mejores marcas del mercado.',cta: 'Ver repuestos' }
        ],
        current: 0, timer: null,
        startTimer() { this.timer = setInterval(() => { this.current = (this.current + 1) % this.slides.length; }, 3000); },
        stopTimer() { if (this.timer) { clearInterval(this.timer); this.timer = null; } },
        goTo(i) { this.current = i; this.stopTimer(); this.startTimer(); },
        next() { this.current = (this.current + 1) % this.slides.length; this.stopTimer(); this.startTimer(); },
        prev() { this.current = this.current > 0 ? this.current - 1 : this.slides.length - 1; this.stopTimer(); this.startTimer(); },
        pause() { this.stopTimer(); },
        resume() { this.startTimer(); }
    }" x-init="startTimer()" @mouseenter="pause()" @mouseleave="resume()" class="relative h-full">
        
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="current === index" x-transition:enter="transition-all duration-1000" x-transition:enter-start="opacity-0 scale-110" x-transition:enter-end="opacity-100 scale-100" class="absolute inset-0 hero-slide">
                <div class="absolute inset-0 bg-cover bg-center" :style="'background-image: url(' + slide.img + ')'"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-black/30"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20"></div>
                <div class="relative h-full flex items-center">
                    <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full">
                        <div class="max-w-3xl">
                            <span class="inline-flex items-center px-4 py-1.5 bg-blue-500/20 backdrop-blur-sm border border-blue-400/30 text-blue-300 text-xs font-semibold uppercase tracking-widest rounded-full mb-6" x-text="slide.tag"></span>
                            <h2 class="text-5xl sm:text-6xl lg:text-7xl xl:text-8xl font-black text-white leading-[0.95] tracking-tight" x-text="slide.title"></h2>
                            <p class="mt-6 text-lg sm:text-xl text-gray-300 max-w-xl leading-relaxed" x-text="slide.desc"></p>
                            <div class="mt-10 flex flex-col sm:flex-row gap-4">
                                <a href="#" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-2xl shadow-blue-500/30 hover:shadow-blue-500/50 group">
                                    <span x-text="slide.cta"></span>
                                    <svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                                <a href="#servicios" class="inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white text-sm font-semibold rounded-full transition-all duration-300 border border-white/20">Conocer mas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <div class="absolute bottom-12 left-0 right-0 z-20">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex gap-3">
                        <template x-for="(slide, index) in slides" :key="index">
                            <button @click="goTo(index)" class="h-1 rounded-full transition-all duration-700 cursor-pointer" :class="current === index ? 'w-12 bg-blue-400' : 'w-8 bg-white/20 hover:bg-white/40'"></button>
                        </template>
                    </div>
                    <div class="text-white/40 text-xs font-mono"><span x-text="'0' + (current + 1)"></span><span class="mx-1">/</span><span x-text="'0' + slides.length"></span></div>
                </div>
            </div>
        </div>

        <button @click="prev()" class="absolute left-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/5 backdrop-blur-sm hover:bg-white/20 border border-white/10 flex items-center justify-center transition-all duration-300 hidden lg:flex cursor-pointer">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button @click="next()" class="absolute right-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/5 backdrop-blur-sm hover:bg-white/20 border border-white/10 flex items-center justify-center transition-all duration-300 hidden lg:flex cursor-pointer">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 float-anim"><svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7"/></svg></div>
</section>

<!-- ========== SERVICES PREMIUM - IMAGE CARDS ========== -->
<section id="servicios" class="relative py-28 lg:py-36 bg-[#0a0a0a] overflow-hidden">
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[1000px] h-[1000px] bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <div x-data="{ visible: false }" x-intersect:enter="visible = true" class="max-w-7xl mx-auto px-6 lg:px-8 relative">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-blue-400 font-semibold text-xs uppercase tracking-[0.2em]" :class="visible ? 'opacity-100' : 'opacity-0'" style="transition: all 0.6s ease-out">Servicios especializados</span>
            <h2 class="mt-4 text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'" style="transition: all 0.6s ease-out 0.1s">
                Todo lo que tu vehiculo <span class="text-blue-400">necesita</span>
            </h2>
            <p class="mt-4 text-gray-400 text-lg" :class="visible ? 'opacity-100' : 'opacity-0'" style="transition: all 0.6s ease-out 0.2s">
                Desde mantenimiento basico hasta reparaciones especializadas, tu vehiculo esta en manos de expertos.
            </p>
        </div>

        <!-- 2x3 Grid of Image Cards -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'" style="transition: all 0.8s ease-out 0.3s">
            
            <!-- 1. Cambio de aceite -->
            <div class="service-card group relative rounded-2xl overflow-hidden cursor-pointer aspect-[4/3] lg:aspect-[3/4]">
                <img src="<?php echo e(asset('images/services/aceite/aceitecar.jpg')); ?>" alt="Cambio de aceite" class="service-img absolute inset-0 w-full h-full object-cover">
                <div class="service-overlay absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent opacity-90 transition-all duration-500"></div>
                <div class="relative h-full flex flex-col justify-end p-6 lg:p-8">
                    <div class="service-glass bg-white/[0.06] backdrop-blur-xl border border-white/10 rounded-xl p-5">
                        <span class="text-xs font-semibold text-blue-300 uppercase tracking-wider">30 min estimado</span>
                        <h3 class="mt-1.5 text-xl lg:text-2xl font-bold text-white">Cambio de aceite</h3>
                        <p class="mt-1.5 text-sm text-gray-300 leading-relaxed">Aceite sintetico de alta calidad y filtros originales para proteger tu motor.</p>
                        <a href="#" class="mt-4 inline-flex items-center text-sm font-medium text-blue-400 hover:text-blue-300 transition gap-1">
                            Ver mas <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 2. Frenos -->
            <div class="service-card group relative rounded-2xl overflow-hidden cursor-pointer aspect-[4/3] lg:aspect-[3/4]">
                <img src="<?php echo e(asset('images/services/frenos/frenoscar.jpg')); ?>" alt="Frenos" class="service-img absolute inset-0 w-full h-full object-cover">
                <div class="service-overlay absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent opacity-90 transition-all duration-500"></div>
                <div class="relative h-full flex flex-col justify-end p-6 lg:p-8">
                    <div class="service-glass bg-white/[0.06] backdrop-blur-xl border border-white/10 rounded-xl p-5">
                        <span class="text-xs font-semibold text-blue-300 uppercase tracking-wider">45 min estimado</span>
                        <h3 class="mt-1.5 text-xl lg:text-2xl font-bold text-white">Sistema de frenos</h3>
                        <p class="mt-1.5 text-sm text-gray-300 leading-relaxed">Pastillas, discos y liquidos de frenos. Seguridad total para tu vehiculo.</p>
                        <a href="#" class="mt-4 inline-flex items-center text-sm font-medium text-blue-400 hover:text-blue-300 transition gap-1">
                            Ver mas <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 3. Alineacion y balanceo -->
            <div class="service-card group relative rounded-2xl overflow-hidden cursor-pointer aspect-[4/3] lg:aspect-[3/4]">
                <img src="<?php echo e(asset('images/services/alineacion/alineacioncar.jpg')); ?>" alt="Alineacion" class="service-img absolute inset-0 w-full h-full object-cover">
                <div class="service-overlay absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent opacity-90 transition-all duration-500"></div>
                <div class="relative h-full flex flex-col justify-end p-6 lg:p-8">
                    <div class="service-glass bg-white/[0.06] backdrop-blur-xl border border-white/10 rounded-xl p-5">
                        <span class="text-xs font-semibold text-blue-300 uppercase tracking-wider">40 min estimado</span>
                        <h3 class="mt-1.5 text-xl lg:text-2xl font-bold text-white">Alineacion y balanceo</h3>
                        <p class="mt-1.5 text-sm text-gray-300 leading-relaxed">Direccion recta, llantas equilibradas y mayor vida util para tus neumaticos.</p>
                        <a href="#" class="mt-4 inline-flex items-center text-sm font-medium text-blue-400 hover:text-blue-300 transition gap-1">
                            Ver mas <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 4. Diagnostico -->
            <div class="service-card group relative rounded-2xl overflow-hidden cursor-pointer aspect-[4/3] lg:aspect-[3/4]">
                <img src="<?php echo e(asset('images/services/diagnostico/diagnosticocar.jpg')); ?>" alt="Diagnostico" class="service-img absolute inset-0 w-full h-full object-cover">
                <div class="service-overlay absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent opacity-90 transition-all duration-500"></div>
                <div class="relative h-full flex flex-col justify-end p-6 lg:p-8">
                    <div class="service-glass bg-white/[0.06] backdrop-blur-xl border border-white/10 rounded-xl p-5">
                        <span class="text-xs font-semibold text-blue-300 uppercase tracking-wider">25 min estimado</span>
                        <h3 class="mt-1.5 text-xl lg:text-2xl font-bold text-white">Diagnostico computarizado</h3>
                        <p class="mt-1.5 text-sm text-gray-300 leading-relaxed">Escaneo electronico completo para identificar fallas con precision milimetrica.</p>
                        <a href="#" class="mt-4 inline-flex items-center text-sm font-medium text-blue-400 hover:text-blue-300 transition gap-1">
                            Ver mas <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 5. Suspension -->
            <div class="service-card group relative rounded-2xl overflow-hidden cursor-pointer aspect-[4/3] lg:aspect-[3/4]">
                <img src="<?php echo e(asset('images/services/suspencion/suspencioncar.jpg')); ?>" alt="Suspension" class="service-img absolute inset-0 w-full h-full object-cover">
                <div class="service-overlay absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent opacity-90 transition-all duration-500"></div>
                <div class="relative h-full flex flex-col justify-end p-6 lg:p-8">
                    <div class="service-glass bg-white/[0.06] backdrop-blur-xl border border-white/10 rounded-xl p-5">
                        <span class="text-xs font-semibold text-blue-300 uppercase tracking-wider">50 min estimado</span>
                        <h3 class="mt-1.5 text-xl lg:text-2xl font-bold text-white">Suspension</h3>
                        <p class="mt-1.5 text-sm text-gray-300 leading-relaxed">Amortiguadores, resortes, brazos de control y revision completa de la direccion.</p>
                        <a href="#" class="mt-4 inline-flex items-center text-sm font-medium text-blue-400 hover:text-blue-300 transition gap-1">
                            Ver mas <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 6. Bateria y electricidad -->
            <div class="service-card group relative rounded-2xl overflow-hidden cursor-pointer aspect-[4/3] lg:aspect-[3/4]">
                <img src="<?php echo e(asset('images/services/bateria-electrical/bateriacar.jpg')); ?>" alt="Bateria" class="service-img absolute inset-0 w-full h-full object-cover">
                <div class="service-overlay absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent opacity-90 transition-all duration-500"></div>
                <div class="relative h-full flex flex-col justify-end p-6 lg:p-8">
                    <div class="service-glass bg-white/[0.06] backdrop-blur-xl border border-white/10 rounded-xl p-5">
                        <span class="text-xs font-semibold text-blue-300 uppercase tracking-wider">20 min estimado</span>
                        <h3 class="mt-1.5 text-xl lg:text-2xl font-bold text-white">Bateria y electricidad</h3>
                        <p class="mt-1.5 text-sm text-gray-300 leading-relaxed">Diagnostico del sistema electrico, carga y reemplazo de baterias.</p>
                        <a href="#" class="mt-4 inline-flex items-center text-sm font-medium text-blue-400 hover:text-blue-300 transition gap-1">
                            Ver mas <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-14 text-center" :class="visible ? 'opacity-100' : 'opacity-0'" style="transition: all 0.6s ease-out 0.6s">
            <a href="#" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-2xl shadow-blue-500/25 group">
                Ver todos los servicios
                <svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- ========== STATS / ABOUT ========== -->
<section id="nosotros" class="relative py-28 lg:py-36 bg-[#0d0d0d] overflow-hidden border-t border-white/5">
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-500/5 rounded-full blur-3xl"></div>
    <div x-data="{ visible: false }" x-intersect:enter="visible = true" class="max-w-7xl mx-auto px-6 lg:px-8 relative">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <span class="text-blue-400 font-semibold text-xs uppercase tracking-[0.2em]" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" style="transition: all 0.6s ease-out">Taller Pro en numeros</span>
                <h2 class="mt-4 text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" style="transition: all 0.6s ease-out 0.1s">Confianza que se <span class="text-blue-400">construye</span></h2>
                <p class="mt-4 text-gray-400 text-lg leading-relaxed" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" style="transition: all 0.6s ease-out 0.2s">En Taller Pro cada servicio cuenta con garantia por escrito. Nuestros mecanicos estan certificados y en constante capacitacion.</p>
                <div class="mt-12 grid grid-cols-3 gap-8" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" style="transition: all 0.8s ease-out 0.3s">
                    <div><p class="text-4xl lg:text-5xl font-black text-white">10+</p><p class="mt-1 text-sm text-gray-500">Anos de experiencia</p></div>
                    <div><p class="text-4xl lg:text-5xl font-black text-white">500+</p><p class="mt-1 text-sm text-gray-500">Clientes atendidos</p></div>
                    <div><p class="text-4xl lg:text-5xl font-black text-white">5K+</p><p class="mt-1 text-sm text-gray-500">Servicios realizados</p></div>
                </div>
                <div class="mt-12 space-y-4" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" style="transition: all 0.8s ease-out 0.4s">
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-white/5 border border-white/5">
                        <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                        <div><p class="text-white font-semibold">Mecanicos certificados</p><p class="text-sm text-gray-400">Capacitacion constante en ultimas tecnologias</p></div>
                    </div>
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-white/5 border border-white/5">
                        <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                        <div><p class="text-white font-semibold">Garantia por escrito</p><p class="text-sm text-gray-400">Todos los servicios tienen garantia</p></div>
                    </div>
                </div>
            </div>
            <div class="relative" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" style="transition: all 1s ease-out 0.3s">
                <div class="aspect-[4/5] rounded-2xl overflow-hidden relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-purple-500/20 mix-blend-overlay"></div>
                    <img src="<?php echo e(asset('images/hero/car3.png')); ?>" alt="Taller" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0d0d0d] via-transparent to-transparent"></div>
                </div>
                <div class="absolute -bottom-6 -left-6 bg-[#1a1a1a] p-5 rounded-xl border border-white/10 shadow-2xl hidden lg:block">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400/20 to-green-600/20 flex items-center justify-center"><svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div>
                        <div><p class="text-white font-bold">+500 clientes</p><p class="text-sm text-gray-400">Nos recomiendan</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== CTA ========== -->
<section class="relative py-28 lg:py-36 overflow-hidden bg-[#0a0a0a]">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-transparent"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-500/10 rounded-full blur-3xl"></div>
    <div x-data="{ visible: false }" x-intersect:enter="visible = true" class="max-w-4xl mx-auto px-6 lg:px-8 text-center relative">
        <h2 class="text-4xl lg:text-6xl font-black text-white leading-tight tracking-tight" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" style="transition: all 0.8s ease-out">Listo para agendar <span class="text-blue-400">tu cita</span>?</h2>
        <p class="mt-6 text-xl text-gray-400" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" style="transition: all 0.8s ease-out 0.1s">Reserva ahora y obten tu presupuesto sin compromiso en menos de un minuto.</p>
        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" style="transition: all 0.8s ease-out 0.2s">
            <a href="#" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-2xl shadow-blue-500/30 group">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Agendar cita ahora
                <svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="tel:+59170000000" class="inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white text-sm font-semibold rounded-full transition-all duration-300 border border-white/20">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Llamar al taller
            </a>
        </div>
    </div>
</section>

<!-- ========== FOOTER ========== -->
<footer id="contacto" class="bg-[#070707] border-t border-white/5">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16 lg:py-20">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-12">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/25">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="text-xl font-bold text-white">Taller Pro</span>
                </div>
                <p class="text-sm text-gray-500 leading-relaxed">Tu taller automotriz de confianza en Santa Cruz de la Sierra.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Menu</h4>
                <ul class="space-y-3"><li><a href="#inicio" class="text-sm text-gray-400 hover:text-white transition">Inicio</a></li><li><a href="#servicios" class="text-sm text-gray-400 hover:text-white transition">Servicios</a></li><li><a href="#nosotros" class="text-sm text-gray-400 hover:text-white transition">Nosotros</a></li><li><a href="#" class="text-sm text-gray-400 hover:text-white transition">Reservar cita</a></li></ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Contacto</h4>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3 text-sm text-gray-400"><svg class="w-4 h-4 mt-0.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Av. Principal #123</li>
                    <li class="flex items-start gap-3 text-sm text-gray-400"><svg class="w-4 h-4 mt-0.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>+591 7 000 0000</li>
                    <li class="flex items-start gap-3 text-sm text-gray-400"><svg class="w-4 h-4 mt-0.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>info@tallerpro.com</li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Horarios</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex justify-between text-gray-400"><span>Lun - Vie</span><span class="text-white">09:00 - 18:00</span></li>
                    <li class="flex justify-between text-gray-400"><span>Sabado</span><span class="text-white">09:00 - 13:00</span></li>
                    <li class="flex justify-between text-gray-600"><span>Domingo</span><span class="text-gray-600">Cerrado</span></li>
                </ul>
            </div>
        </div>
        <div class="mt-16 pt-8 border-t border-white/5 text-center text-sm text-gray-600"><p>&copy; <?php echo e(date('Y')); ?> Taller Pro. Todos los derechos reservados.</p></div>
    </div>
</footer>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.directive('intersect', (el, { expression }, { evaluate }) => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => { if (entry.isIntersecting) { evaluate(expression); observer.unobserve(el); } });
            }, { threshold: 0.1 });
            observer.observe(el);
        });
    });
</script>
</body>
</html>
<?php /**PATH C:\laragon\www\TallerPro\resources\views/welcome.blade.php ENDPATH**/ ?>
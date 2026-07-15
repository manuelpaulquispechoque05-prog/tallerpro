@extends('layouts.panel')
@section('title', 'Detalle: ' . $vehiculo->placa)

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Encabezado Principal -->
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8 mb-6 shadow-xl shadow-black/20 relative overflow-hidden">
        <!-- Decoracion de fondo -->
        <div class="absolute top-0 right-0 p-12 opacity-5 pointer-events-none text-white">
            <svg class="w-64 h-64 rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
        </div>

        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 relative z-10">
            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 flex flex-col items-center justify-center text-white shadow-xl shadow-blue-500/30 shrink-0 border border-white/10 transform rotate-[-3deg]">
                <span class="text-[10px] font-bold tracking-widest uppercase opacity-70 mb-1">PLACA</span>
                <span class="text-xl font-black tracking-widest font-mono">{{ $vehiculo->placa }}</span>
            </div>
            
            <div class="text-center sm:text-left flex-1">
                <div class="flex items-center justify-center sm:justify-start gap-3 mb-1">
                    <h1 class="text-3xl font-black text-white tracking-tight">{{ $vehiculo->marca?->nombre ?? 'Sin Marca' }} <span class="text-blue-400">{{ $vehiculo->modelo?->nombre ?? '' }}</span></h1>
                </div>
                <p class="text-sm text-gray-400 mt-1 flex items-center justify-center sm:justify-start gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                    VIN: <span class="font-mono text-gray-300 font-medium">{{ $vehiculo->vin ?? 'No registrado' }}</span>
                </p>
                
                <div class="flex flex-wrap gap-2 mt-4 justify-center sm:justify-start">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-white/5 border border-white/10 text-gray-300 shadow-sm">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Año {{ $vehiculo->anio }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-white/5 border border-white/10 text-gray-300 shadow-sm capitalize">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                        {{ $vehiculo->color ?? 'Sin color' }}
                    </span>
                    @if($vehiculo->activo)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 shadow-sm uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Activo
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-rose-500/10 border border-rose-500/20 text-rose-400 shadow-sm uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Inactivo
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-2 shrink-0 w-full sm:w-auto mt-4 sm:mt-0">
                <a href="{{ route('panel.vehiculos.edit', $vehiculo->id) }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar Datos
                </a>
                <a href="{{ route('panel.vehiculos.index') }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-sm font-bold rounded-xl transition-all hover:text-white">Volver</a>
            </div>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-5 mb-6">
        <!-- Tarjeta de Cliente -->
        <div class="animate-in animate-in-d2 glass-card rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-blue-500/5 rounded-full blur-2xl -mr-10 -mt-10 transition-transform group-hover:scale-150"></div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-indigo-500/30 flex items-center justify-center text-xl font-bold text-indigo-300 shadow-inner">
                    {{ $vehiculo->cliente ? substr($vehiculo->cliente->nombre_completo, 0, 1) : '?' }}
                </div>
                <div>
                    <p class="text-[10px] font-bold text-indigo-400/80 uppercase tracking-widest mb-0.5">Propietario / Cliente</p>
                    <p class="text-lg font-bold text-white">{{ $vehiculo->cliente?->nombre_completo ?? 'No asignado' }}</p>
                    @if($vehiculo->cliente?->telefono)
                        <p class="text-sm text-gray-400 mt-0.5 flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> {{ $vehiculo->cliente->telefono }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tarjeta de Kilometraje -->
        <div class="animate-in animate-in-d3 glass-card rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-2xl -mr-10 -mt-10 transition-transform group-hover:scale-150"></div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-emerald-500/20 to-teal-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shadow-inner">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-emerald-400/80 uppercase tracking-widest mb-0.5">Kilometraje Actual</p>
                    <p class="text-2xl font-black text-white tracking-tight">{{ number_format($vehiculo->kilometraje) }} <span class="text-sm font-medium text-gray-400">km</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalles Tecnicos -->
    <div class="animate-in animate-in-d4 glass-card rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/[0.06] bg-white/[0.02] flex items-center gap-3">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v1a3 3 0 106 0v-1m-6 0a3 3 0 006 0M9 17h6m-6 0H5a2 2 0 01-2-2v-5a2 2 0 012-2h1m14 4h-1m-1 0a2 2 0 01-2-2V7a2 2 0 012-2h1m-1 0a2 2 0 012 2v5a2 2 0 01-2 2z"/></svg>
            <h2 class="text-sm font-bold text-gray-100 uppercase tracking-wider">Ficha Técnica Completa</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5 flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> Marca</p>
                    <p class="text-base font-semibold text-gray-200">{{ $vehiculo->marca?->nombre ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5 flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> Modelo</p>
                    <p class="text-base font-semibold text-gray-200">{{ $vehiculo->modelo?->nombre ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5 flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> Año Fabricación</p>
                    <p class="text-base font-semibold text-gray-200">{{ $vehiculo->anio }}</p>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5 flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> Color Principal</p>
                    <p class="text-base font-semibold text-gray-200 capitalize">{{ $vehiculo->color ?? '—' }}</p>
                </div>
                <div class="col-span-2 md:col-span-2">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5 flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> Registro en Sistema</p>
                    <p class="text-base font-semibold text-gray-200">{{ $vehiculo->created_at->format('d \d\e F, Y - H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

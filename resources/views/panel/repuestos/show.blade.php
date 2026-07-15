@extends('layouts.panel')
@section('title', 'Detalle: ' . $repuesto->nombre)
@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Encabezado Principal -->
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8 mb-6 shadow-xl shadow-black/20 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-12 opacity-5 pointer-events-none text-white">
            <svg class="w-64 h-64 rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 relative z-10">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-indigo-500/30 shrink-0 border border-white/10">
                {{ substr($repuesto->nombre, 0, 1) }}
            </div>
            <div class="flex-1 text-center sm:text-left">
                <h1 class="text-2xl font-black text-white tracking-tight">{{ $repuesto->nombre }}</h1>
                <p class="text-sm text-gray-400 mt-1 flex items-center justify-center sm:justify-start gap-2">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Código (SKU): <span class="font-mono text-gray-200 font-bold bg-white/5 px-2 py-0.5 rounded">{{ $repuesto->codigo }}</span>
                </p>
                <div class="mt-4 flex flex-wrap gap-2 justify-center sm:justify-start">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold {{ $repuesto->activo ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-gray-500/10 text-gray-400 border border-gray-500/20' }} uppercase tracking-wider">
                        @if($repuesto->activo) <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> @endif
                        {{ $repuesto->activo ? 'Pieza Activa' : 'Pieza Inactiva' }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-white/5 border border-white/10 text-gray-300">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                        Medida: {{ $repuesto->unidad_medida }}
                    </span>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 shrink-0 w-full sm:w-auto mt-4 sm:mt-0">
                <a href="{{ route('panel.repuestos.edit', $repuesto->id) }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-400 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/25 hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Modificar
                </a>
                <a href="{{ route('panel.repuestos.index') }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-sm font-bold rounded-xl transition-all">Volver</a>
            </div>
        </div>
    </div>

    <!-- Contenido en Grid -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Columna Izquierda: Detalles e info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="animate-in animate-in-d2 glass-card rounded-2xl overflow-hidden shadow-lg shadow-black/10">
                <div class="px-6 py-4 border-b border-white/[0.06] bg-white/[0.02] flex items-center gap-3">
                    <div class="p-1.5 bg-indigo-500/20 rounded-lg text-indigo-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
                    <h2 class="text-sm font-bold text-gray-100 uppercase tracking-wider">Ficha de Información</h2>
                </div>
                <div class="p-6 grid sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Categoría</p>
                        <p class="text-base font-semibold text-gray-200 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-500/50"></span>
                            {{ $repuesto->categoria?->nombre ?? 'Sin especificar' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Proveedor Oficial</p>
                        <p class="text-base font-semibold text-gray-200 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            {{ $repuesto->proveedor?->nombre ?? 'No registrado' }}
                        </p>
                    </div>
                    <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Precio de Compra (Costo)</p>
                        <p class="text-lg font-medium text-gray-300">${{ number_format($repuesto->precio_compra, 2) }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                        <p class="text-[10px] font-bold text-emerald-500/70 uppercase tracking-widest mb-1">Precio de Venta al Público</p>
                        <p class="text-2xl font-black text-emerald-400 drop-shadow-[0_0_8px_rgba(16,185,129,0.2)]">${{ number_format($repuesto->precio_venta, 2) }}</p>
                    </div>
                </div>
            </div>

            @if($repuesto->descripcion)
            <div class="animate-in animate-in-d3 glass-card rounded-2xl p-6 shadow-lg shadow-black/10">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg> Descripción Detallada</p>
                <div class="text-sm text-gray-300 leading-relaxed bg-white/[0.02] p-4 rounded-xl border border-white/[0.04]">
                    {{ $repuesto->descripcion }}
                </div>
            </div>
            @endif
        </div>

        <!-- Columna Derecha: Inventario -->
        <div class="animate-in animate-in-d4 lg:col-span-1">
            <div class="glass-card rounded-2xl overflow-hidden shadow-lg shadow-black/10 h-full">
                <div class="px-6 py-4 border-b border-white/[0.06] bg-white/[0.02] flex items-center justify-between">
                    <h2 class="text-sm font-bold text-gray-100 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Stock Actual
                    </h2>
                    @if($repuesto->inventario)
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-white/10 text-gray-300">{{ $repuesto->inventario->sucursal?->nombre ?? 'Sucursal Principal' }}</span>
                    @endif
                </div>

                <div class="p-6 flex flex-col items-center justify-center min-h-[250px]">
                    @if($repuesto->inventario)
                        @php
                            $inv = $repuesto->inventario;
                            $isLow = $inv->stock_actual <= $inv->stock_minimo;
                        @endphp
                        
                        <!-- Circulo de Stock -->
                        <div class="relative w-36 h-36 rounded-full flex flex-col items-center justify-center mb-6 border-4 {{ $isLow ? 'border-rose-500/30 bg-rose-500/5' : 'border-emerald-500/30 bg-emerald-500/5' }}">
                            <div class="absolute inset-0 rounded-full border-[6px] border-transparent {{ $isLow ? 'border-t-rose-500 border-r-rose-500 rotate-45' : 'border-t-emerald-500 border-r-emerald-500 border-b-emerald-500 -rotate-45' }}"></div>
                            <span class="text-4xl font-black {{ $isLow ? 'text-rose-400 drop-shadow-[0_0_10px_rgba(244,63,94,0.3)]' : 'text-emerald-400 drop-shadow-[0_0_10px_rgba(16,185,129,0.3)]' }} leading-none">{{ $inv->stock_actual }}</span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">Unidades</span>
                        </div>

                        <div class="w-full space-y-3">
                            <div class="flex justify-between items-center p-3 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                                <span class="text-xs font-bold text-gray-500 uppercase">Stock Mínimo Requerido</span>
                                <span class="text-sm font-bold text-gray-200">{{ $inv->stock_minimo }}</span>
                            </div>

                            @if($isLow)
                                <div class="mt-4 p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl flex items-start gap-3">
                                    <div class="p-1 bg-rose-500/20 rounded-lg text-rose-400 shrink-0 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-rose-400">¡Alerta de inventario!</p>
                                        <p class="text-xs text-rose-400/80 mt-0.5">El stock está por debajo del mínimo. Es necesario solicitar reposición al proveedor pronto.</p>
                                    </div>
                                </div>
                            @else
                                <div class="mt-4 p-3 bg-emerald-500/5 border border-emerald-500/10 rounded-xl flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-xs font-bold text-emerald-400">Nivel de inventario óptimo</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 mb-4 border border-white/10">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-300">Inventario no inicializado</p>
                            <p class="text-xs text-gray-500 mt-1 mb-4">Esta pieza aún no tiene un registro de stock físico en sucursales.</p>
                            <a href="#" class="inline-flex items-center px-4 py-2 border border-indigo-500/50 text-indigo-400 text-[10px] font-bold uppercase tracking-wider rounded-full hover:bg-indigo-500/10 transition-colors">Configurar Stock</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

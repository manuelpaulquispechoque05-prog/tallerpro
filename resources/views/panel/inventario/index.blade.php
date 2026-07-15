@extends('layouts.panel')
@section('title', 'Inventario')

@section('content')
<!-- Warehouse indicators -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    <div class="glass-card rounded-2xl p-5">
        <div class="flex items-center gap-3"><div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center"><svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></div>
        <div><p class="text-2xl font-bold text-white">{{ $items->total() }}</p><p class="text-xs text-gray-500">Productos</p></div></div>
    </div>
    <div class="glass-card rounded-2xl p-5">
        <div class="flex items-center gap-3"><div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500/20 to-red-600/20 flex items-center justify-center"><svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.054 0 1.632-1.159.9-2l-6.929-6.858c-.494-.49-1.306-.49-1.8 0L3.162 17c-.732.841.154 2.1.9 2.1z"/></svg></div>
        <div><p class="text-2xl font-bold text-red-400">{{ $alertas['agotados']->count() }}</p><p class="text-xs text-gray-500">Stock critico</p></div></div>
    </div>
    <div class="glass-card rounded-2xl p-5">
        <div class="flex items-center gap-3"><div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500/20 to-amber-600/20 flex items-center justify-center"><svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
        <div><p class="text-2xl font-bold text-amber-400">{{ $alertas['bajos']->count() }}</p><p class="text-xs text-gray-500">Stock bajo</p></div></div>
    </div>
    <div class="glass-card rounded-2xl p-5">
        <div class="flex items-center gap-3"><div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500/20 to-green-600/20 flex items-center justify-center"><svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
        <div><p class="text-2xl font-bold text-green-400">{{ $alertas['bajos']->count() }}</p><p class="text-xs text-gray-500">Stock normal</p></div></div>
    </div>
</div>

<!-- Action buttons -->
<div class="flex gap-3 mb-6">
    <a href="{{ route('panel.inventario.ingreso') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-blue-500/25">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        Nuevo ingreso
    </a>
    <a href="{{ route('panel.inventario.movimientos') }}" class="inline-flex items-center px-5 py-2.5 bg-white/5 border border-white/10 text-gray-300 text-sm font-medium rounded-xl transition">Movimientos</a>
</div>

@php $hasAlertas = $alertas['agotados']->count() > 0 || $alertas['bajos']->count() > 0; @endphp
@if($hasAlertas)
<div class="animate-in glass-card rounded-2xl p-5 lg:p-6 mb-6">
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.054 0 1.632-1.159.9-2l-6.929-6.858c-.494-.49-1.306-.49-1.8 0L3.162 17c-.732.841.154 2.1.9 2.1z"/></svg>
        <h3 class="text-sm font-semibold text-gray-100">Alertas de inventario</h3>
    </div>
    <div class="grid sm:grid-cols-2 gap-3">
        @foreach($alertas['agotados'] as $a)
        <div class="flex items-center justify-between p-3 rounded-lg bg-red-500/10 border border-red-500/20">
            <div><span class="text-sm text-gray-200">{{ $a->repuesto?->nombre }}</span><span class="text-xs text-gray-500 ml-2">{{ $a->repuesto?->codigo }}</span></div>
            <span class="text-xs font-semibold text-red-400">AGOTADO (0)</span>
        </div>
        @endforeach
        @foreach($alertas['bajos'] as $a)
        <div class="flex items-center justify-between p-3 rounded-lg bg-amber-500/10 border border-amber-500/20">
            <div><span class="text-sm text-gray-200">{{ $a->repuesto?->nombre }}</span><span class="text-xs text-gray-500 ml-2">{{ $a->repuesto?->codigo }}</span></div>
            <span class="text-xs font-semibold text-amber-400">{{ $a->stock_actual }} / {{ $a->stock_minimo }} min</span>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="glass-card rounded-2xl overflow-hidden">
    <div class="px-5 lg:px-6 py-4 border-b border-white/[0.06]">
        <h3 class="text-sm font-semibold text-gray-100">Inventario general</h3>
        <p class="text-xs text-gray-500 mt-0.5">Stock por repuesto</p>
    </div>
    <div class="px-5 lg:px-6 py-3 border-b border-white/[0.06]">
        <form method="GET" x-data>
            <div class="relative max-w-md">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar por repuesto..." class="w-full pl-10 pr-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" x-on:input.debounce.500ms="$el.form.submit()">
            </div>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/[0.04]">
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Repuesto</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Sucursal</th>
                    <th class="px-5 py-3.5 text-right text-[10px] font-semibold uppercase text-gray-600">Stock</th>
                    <th class="px-5 py-3.5 text-right text-[10px] font-semibold uppercase text-gray-600">Minimo</th>
                    <th class="px-5 py-3.5 text-center text-[10px] font-semibold uppercase text-gray-600">Estado</th>
                    <th class="px-5 py-3.5 text-center text-[10px] font-semibold uppercase text-gray-600">Historial</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                    @php
                        $alerta = $i->stock_actual <= 0 ? 'agotado' : ($i->stock_actual <= $i->stock_minimo ? 'bajo' : 'normal');
                        $colorAlerta = ['agotado' => 'text-red-400', 'bajo' => 'text-amber-400', 'normal' => 'text-green-400'];
                        $badgeAlerta = ['agotado' => 'bg-red-500/10 text-red-400 Stock agotado', 'bajo' => 'bg-amber-500/10 text-amber-400 Stock bajo', 'normal' => 'bg-green-500/10 text-green-400 Normal'];
                        $badgeParts = explode(' ', $badgeAlerta[$alerta], 3);
                    @endphp
                    <tr class="border-b border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4"><span class="text-sm text-gray-200">{{ $i->repuesto?->nombre }}</span><br><span class="text-xs text-gray-600">{{ $i->repuesto?->codigo }}</span></td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $i->sucursal?->nombre ?? 'Principal' }}</td>
                        <td class="px-5 py-4 text-right text-sm font-medium {{ $colorAlerta[$alerta] }}">{{ $i->stock_actual }}</td>
                        <td class="px-5 py-4 text-right text-sm text-gray-500">{{ $i->stock_minimo }}</td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $badgeParts[0] }} {{ $badgeParts[1] }}">{{ $badgeParts[2] }}</span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('panel.inventario.historial', $i->repuesto_id) }}" class="text-xs text-blue-400 hover:text-blue-300 transition">Ver movimientos</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-sm text-gray-500">Sin registros de inventario</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($items->hasPages())
        <div class="px-5 lg:px-6 py-4 border-t border-white/[0.06]">{{ $items->links() }}</div>
    @endif
</div>
@endsection

@extends('layouts.panel')
@section('title', $vehiculo->placa)

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="animate-in glass-card rounded-2xl overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600/10 to-transparent p-6 lg:p-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <div class="w-28 h-28 rounded-2xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 border border-white/10 flex items-center justify-center shrink-0">
                    <svg class="w-14 h-14 text-blue-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div class="text-center sm:text-left flex-1">
                    <div class="flex items-center gap-3 justify-center sm:justify-start">
                        <h1 class="text-2xl font-bold text-white">{{ $vehiculo->marca?->nombre }} {{ $vehiculo->modelo?->nombre }}</h1>
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400">{{ $vehiculo->anio }}</span>
                    </div>
                    <div class="mt-3 flex flex-wrap gap-4 justify-center sm:justify-start">
                        <span class="text-sm"><span class="text-gray-500">Placa:</span> <span class="font-mono text-gray-200 font-bold text-lg">{{ $vehiculo->placa }}</span></span>
                        <span class="text-sm"><span class="text-gray-500">VIN:</span> <span class="font-mono text-xs text-gray-400">{{ $vehiculo->vin ?? '—' }}</span></span>
                        <span class="text-sm"><span class="text-gray-500">Color:</span> <span class="text-gray-200">{{ $vehiculo->color ?? '—' }}</span></span>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2 justify-center sm:justify-start">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium {{ $vehiculo->activo ? 'bg-green-500/10 text-green-400' : 'bg-gray-500/10 text-gray-400' }}">{{ $vehiculo->activo ? 'Activo' : 'Inactivo' }}</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-500/10 text-gray-400">{{ number_format($vehiculo->kilometraje) }} km</span>
                    </div>
                </div>
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('panel.vehiculos.edit', $vehiculo->id) }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-blue-500/25">Editar</a>
                    <a href="{{ route('panel.vehiculos.index') }}" class="px-4 py-2 bg-white/5 border border-white/10 text-gray-300 text-xs font-medium rounded-full transition">Volver</a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-4 mb-6">
        <div class="animate-in animate-in-d2 glass-card rounded-2xl p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500/20 to-green-600/20 flex items-center justify-center"><svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                <div><p class="text-xs text-gray-500 uppercase tracking-wider">Propietario</p><p class="text-sm font-medium text-gray-200">{{ $vehiculo->cliente?->nombre_completo ?? '—' }}</p></div>
            </div>
        </div>
        <div class="animate-in animate-in-d3 glass-card rounded-2xl p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center"><svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                <div><p class="text-xs text-gray-500 uppercase tracking-wider">Registrado</p><p class="text-sm font-medium text-gray-200">{{ $vehiculo->created_at->format('d/m/Y') }}</p></div>
            </div>
        </div>
        <div class="animate-in animate-in-d4 glass-card rounded-2xl p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500/20 to-purple-600/20 flex items-center justify-center"><svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <div><p class="text-xs text-gray-500 uppercase tracking-wider">Ordenes</p><p class="text-sm font-medium text-gray-200">0</p></div>
            </div>
        </div>
    </div>

    <div class="animate-in animate-in-d4 glass-card rounded-2xl p-5 lg:p-6 mb-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Ficha tecnica</h2>
        <div class="grid sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]"><p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Marca</p><p class="text-sm font-medium text-gray-200">{{ $vehiculo->marca?->nombre ?? '—' }}</p></div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]"><p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Modelo</p><p class="text-sm font-medium text-gray-200">{{ $vehiculo->modelo?->nombre ?? '—' }}</p></div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]"><p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Anio</p><p class="text-sm font-medium text-gray-200">{{ $vehiculo->anio }}</p></div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]"><p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Color</p><p class="text-sm font-medium text-gray-200">{{ $vehiculo->color ?? '—' }}</p></div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]"><p class="text-xs text-gray-500 uppercase tracking-wider mb-1">VIN</p><p class="text-sm font-mono text-gray-200">{{ $vehiculo->vin ?? '—' }}</p></div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]"><p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Kilometraje</p><p class="text-sm font-medium text-gray-200">{{ number_format($vehiculo->kilometraje) }} km</p></div>
        </div>
    </div>

    <div class="animate-in animate-in-d5 glass-card rounded-2xl p-5 lg:p-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Historial de mantenimientos</h2>
        <div class="text-center py-8">
            <svg class="w-10 h-10 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p class="text-sm text-gray-500">Sin ordenes de trabajo registradas</p>
            <p class="text-xs text-gray-600 mt-1">El historial aparecera cuando el vehiculo tenga ordenes asociadas.</p>
        </div>
    </div>
</div>
@endsection

@extends('layouts.panel')
@section('title', 'Vehiculo: ' . $vehiculo->placa)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8 mb-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-2xl font-bold shadow-xl shadow-blue-500/20 shrink-0">
                {{ substr($vehiculo->placa, 0, 1) }}
            </div>
            <div class="text-center sm:text-left flex-1">
                <h1 class="text-xl font-bold text-white">{{ $vehiculo->marca?->nombre }} {{ $vehiculo->modelo?->nombre }}</h1>
                <p class="text-sm text-gray-400 mt-1">Placa: <span class="font-mono text-gray-200">{{ $vehiculo->placa }}</span></p>
                <div class="flex flex-wrap gap-2 mt-3 justify-center sm:justify-start">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400">{{ $vehiculo->anio }}</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium {{ $vehiculo->activo ? 'bg-green-500/10 text-green-400' : 'bg-gray-500/10 text-gray-400' }}">
                        {{ $vehiculo->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
            <div class="flex gap-2 shrink-0">
                <a href="{{ route('panel.vehiculos.edit', $vehiculo->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-xs font-semibold rounded-full transition-all duration-300 shadow-lg shadow-blue-500/25">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar
                </a>
                <a href="{{ route('panel.vehiculos.index') }}" class="inline-flex items-center px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-xs font-medium rounded-full transition">Volver</a>
            </div>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-4 mb-6">
        <div class="animate-in animate-in-d2 glass-card rounded-2xl p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Cliente</p>
            <p class="text-sm font-semibold text-white">{{ $vehiculo->cliente?->nombre_completo ?? '—' }}</p>
        </div>
        <div class="animate-in animate-in-d3 glass-card rounded-2xl p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kilometraje</p>
            <p class="text-sm font-semibold text-white">{{ number_format($vehiculo->kilometraje) }} km</p>
        </div>
    </div>

    <div class="animate-in animate-in-d4 glass-card rounded-2xl p-5 lg:p-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Informacion del vehiculo</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Marca</p>
                <p class="text-sm font-medium text-gray-200">{{ $vehiculo->marca?->nombre ?? '—' }}</p>
            </div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Modelo</p>
                <p class="text-sm font-medium text-gray-200">{{ $vehiculo->modelo?->nombre ?? '—' }}</p>
            </div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Anio</p>
                <p class="text-sm font-medium text-gray-200">{{ $vehiculo->anio }}</p>
            </div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Color</p>
                <p class="text-sm font-medium text-gray-200">{{ $vehiculo->color ?? '—' }}</p>
            </div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">VIN</p>
                <p class="text-sm font-medium text-gray-200 font-mono">{{ $vehiculo->vin ?? '—' }}</p>
            </div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Registrado</p>
                <p class="text-sm font-medium text-gray-200">{{ $vehiculo->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

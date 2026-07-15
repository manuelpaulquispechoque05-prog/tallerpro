@extends('layouts.portal')
@section('title', $vehiculo->placa)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="glass-card rounded-2xl p-6 lg:p-8 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center">
                <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div class="flex-1">
                <h1 class="text-xl font-bold text-white">{{ $vehiculo->marca?->nombre }} {{ $vehiculo->modelo?->nombre }}</h1>
                <p class="text-sm text-gray-400 font-mono mt-0.5">{{ $vehiculo->placa }}</p>
            </div>
            <a href="{{ route('portal.vehiculos.index') }}" class="text-sm text-gray-400 hover:text-white transition">Volver</a>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-4 mb-6">
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Marca</p>
            <p class="text-sm font-medium text-white">{{ $vehiculo->marca?->nombre ?? '—' }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Modelo</p>
            <p class="text-sm font-medium text-white">{{ $vehiculo->modelo?->nombre ?? '—' }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Anio</p>
            <p class="text-sm font-medium text-white">{{ $vehiculo->anio }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Color</p>
            <p class="text-sm font-medium text-white">{{ $vehiculo->color ?? '—' }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">VIN</p>
            <p class="text-sm font-mono text-white">{{ $vehiculo->vin ?? '—' }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Kilometraje</p>
            <p class="text-sm font-medium text-white">{{ number_format($vehiculo->kilometraje) }} km</p>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-5 lg:p-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Historial de ordenes</h2>
        @if($vehiculo->ordenesTrabajo->count() > 0)
            <div class="space-y-2">
                @foreach($vehiculo->ordenesTrabajo as $o)
                <div class="flex items-center justify-between p-3 rounded-lg bg-white/[0.02] border border-white/[0.04]">
                    <div>
                        <p class="text-sm text-gray-200">Orden #{{ $o->id }}</p>
                        <p class="text-xs text-gray-500">{{ $o->fecha_ingreso?->format('d/m/Y') }}</p>
                    </div>
                    <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $o->estado === 'completado' ? 'bg-green-500/10 text-green-400' : ($o->estado === 'en_proceso' ? 'bg-blue-500/10 text-blue-400' : 'bg-gray-500/10 text-gray-400') }}">{{ ucfirst($o->estado) }}</span>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 text-center py-4">Este vehiculo no tiene ordenes de trabajo registradas.</p>
        @endif
    </div>
</div>
@endsection

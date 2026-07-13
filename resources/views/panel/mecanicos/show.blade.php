@extends('layouts.panel')
@section('title', $item->nombre_completo)
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8 mb-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-2xl font-bold shadow-xl shrink-0">
                {{ substr($item->nombre, 0, 1) }}
            </div>
            <div class="text-center sm:text-left flex-1">
                <h1 class="text-xl font-bold text-white">{{ $item->nombre_completo }}</h1>
                <p class="text-sm text-gray-400 mt-1">{{ $item->especialidad?->nombre ?? '—' }}</p>
                <div class="flex flex-wrap gap-2 mt-3 justify-center sm:justify-start">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium {{ $item->activo ? 'bg-green-500/10 text-green-400' : 'bg-gray-500/10 text-gray-400' }}">{{ $item->activo ? 'Activo' : 'Inactivo' }}</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400">Desde {{ $item->fecha_contratacion?->format('d/m/Y') }}</span>
                </div>
            </div>
            <a href="{{ route('panel.mecanicos.edit', $item->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-blue-500/25">Editar</a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-3 mb-6">
        <div class="animate-in animate-in-d2 glass-card rounded-2xl p-4 text-center">
            <p class="text-2xl font-bold text-white">{{ $item->citas_asignadas ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1">Citas asignadas</p>
        </div>
        <div class="animate-in animate-in-d3 glass-card rounded-2xl p-4 text-center">
            <p class="text-2xl font-bold text-white">{{ $item->ordenes_activas ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1">Ordenes activas</p>
        </div>
        <div class="animate-in animate-in-d4 glass-card rounded-2xl p-4 text-center">
            <p class="text-2xl font-bold text-white">{{ $item->ordenes_finalizadas ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1">Finalizadas</p>
        </div>
    </div>

    <div class="animate-in animate-in-d4 glass-card rounded-2xl p-5 lg:p-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Informacion</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Correo</p>
                <p class="text-sm text-gray-200">{{ $item->user?->email ?? '—' }}</p>
            </div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Especialidad</p>
                <p class="text-sm text-gray-200">{{ $item->especialidad?->nombre ?? '—' }}</p>
            </div>
            @if($item->descripcion)
            <div class="sm:col-span-2 p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Perfil</p>
                <p class="text-sm text-gray-400">{{ $item->descripcion }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('layouts.panel')
@section('title', 'Cliente: ' . $cliente->nombre_completo)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Profile header -->
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8 mb-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-2xl font-bold shadow-xl shadow-blue-500/20 shrink-0">
                {{ substr($cliente->nombre, 0, 1) }}{{ substr($cliente->apellido, 0, 1) }}
            </div>
            <div class="text-center sm:text-left flex-1">
                <h1 class="text-xl font-bold text-white">{{ $cliente->nombre_completo }}</h1>
                <p class="text-sm text-gray-400 mt-1">{{ $cliente->email ?? 'Sin correo' }}</p>
                <div class="flex flex-wrap gap-2 mt-3 justify-center sm:justify-start">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium {{ $cliente->activo ? 'bg-green-500/10 text-green-400' : 'bg-gray-500/10 text-gray-400' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $cliente->activo ? 'bg-green-400' : 'bg-gray-400' }}"></span>
                        {{ $cliente->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400">
                        CI: {{ $cliente->ci_nit }}
                    </span>
                </div>
            </div>
            <div class="flex gap-2 shrink-0">
                <a href="{{ route('panel.clientes.edit', $cliente->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-xs font-semibold rounded-full transition-all duration-300 shadow-lg shadow-blue-500/25">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar
                </a>
                <a href="{{ route('panel.clientes.index') }}" class="inline-flex items-center px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-xs font-medium rounded-full transition">Volver</a>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        <div class="animate-in animate-in-d2 glass-card rounded-2xl p-4 text-center">
            <p class="text-2xl font-bold text-white">{{ $cliente->vehiculos_count ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1">Vehiculos</p>
        </div>
        <div class="animate-in animate-in-d3 glass-card rounded-2xl p-4 text-center">
            <p class="text-2xl font-bold text-white">{{ $cliente->citas_count ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1">Citas</p>
        </div>
        <div class="animate-in animate-in-d4 glass-card rounded-2xl p-4 text-center">
            <p class="text-2xl font-bold text-white">{{ $cliente->ordenes_trabajo_count ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1">Ordenes</p>
        </div>
        <div class="animate-in animate-in-d5 glass-card rounded-2xl p-4 text-center">
            <p class="text-2xl font-bold text-white">{{ $cliente->created_at->format('d/m') }}</p>
            <p class="text-xs text-gray-500 mt-1">Registro</p>
        </div>
    </div>

    <!-- Info -->
    <div class="animate-in animate-in-d4 glass-card rounded-2xl p-5 lg:p-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Informacion personal</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Nombre completo</p>
                <p class="text-sm font-medium text-gray-200">{{ $cliente->nombre_completo }}</p>
            </div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">CI / NIT</p>
                <p class="text-sm font-medium text-gray-200">{{ $cliente->ci_nit }}</p>
            </div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Telefono</p>
                <p class="text-sm font-medium text-gray-200">{{ $cliente->telefono }}</p>
            </div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04]">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Correo</p>
                <p class="text-sm font-medium text-gray-200">{{ $cliente->email ?? '—' }}</p>
            </div>
            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.04] sm:col-span-2">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Direccion</p>
                <p class="text-sm font-medium text-gray-200">{{ $cliente->direccion ?? '—' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

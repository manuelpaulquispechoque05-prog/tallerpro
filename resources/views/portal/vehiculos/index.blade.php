@extends('layouts.portal')
@section('title', 'Mis vehiculos')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-white">Mis vehiculos</h1>
        <p class="text-sm text-gray-400 mt-1">Vehiculos registrados a tu nombre</p>
    </div>
    <a href="{{ route('portal.vehiculos.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Agregar vehiculo
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400">{{ session('success') }}</div>
@endif

@if($vehiculos->count() > 0)
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($vehiculos as $v)
    <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all duration-300">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-100">{{ $v->marca?->nombre }} {{ $v->modelo?->nombre }}</p>
                <p class="text-xs text-gray-500 font-mono">{{ $v->placa }}</p>
            </div>
        </div>
        <div class="space-y-1 text-xs text-gray-500">
            <div class="flex justify-between"><span>Anio</span><span class="text-gray-300">{{ $v->anio }}</span></div>
            <div class="flex justify-between"><span>Color</span><span class="text-gray-300">{{ $v->color ?? '—' }}</span></div>
            <div class="flex justify-between"><span>Kilometraje</span><span class="text-gray-300">{{ number_format($v->kilometraje) }} km</span></div>
        </div>
        <div class="mt-3 pt-3 border-t border-white/[0.06]">
            <a href="{{ route('portal.vehiculos.show', $v->id) }}" class="text-xs font-medium text-blue-400 hover:text-blue-300 transition">Ver detalle</a>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="glass-card rounded-2xl p-10 text-center">
    <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
    <p class="text-sm text-gray-500">No tienes vehiculos registrados</p>
    <a href="{{ route('portal.vehiculos.create') }}" class="inline-block mt-3 text-sm text-blue-400 hover:text-blue-300 transition">Registrar tu primer vehiculo</a>
</div>
@endif
@endsection

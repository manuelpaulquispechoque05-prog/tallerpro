@extends('layouts.portal')
@section('title', 'Mi cuenta')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white">Bienvenido, {{ $user->name }}</h1>
    <p class="text-sm text-gray-400 mt-1">Panel de cliente de Taller Pro</p>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="glass-card rounded-2xl p-5">
        <p class="text-2xl font-bold text-white">{{ $cliente?->vehiculos?->count() ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-1">Vehiculos</p>
    </div>
    <div class="glass-card rounded-2xl p-5">
        <p class="text-2xl font-bold text-blue-400">{{ $cliente?->citas?->count() ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-1">Citas</p>
    </div>
    <div class="glass-card rounded-2xl p-5">
        <p class="text-2xl font-bold text-amber-400">{{ $cliente?->ordenesTrabajo?->count() ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-1">Ordenes</p>
    </div>
    <div class="glass-card rounded-2xl p-5">
        <p class="text-2xl font-bold text-green-400">—</p>
        <p class="text-xs text-gray-500 mt-1">Proximo servicio</p>
    </div>
</div>

@if(!$cliente)
<div class="glass-card rounded-2xl p-6 text-center">
    <p class="text-sm text-gray-400">Aun no tienes un perfil de cliente completo.</p>
    <p class="text-xs text-gray-600 mt-1">Cuando registres tu primer vehiculo o reserves una cita, tus datos apareceran aqui.</p>
</div>
@endif

<div class="glass-card rounded-2xl p-6">
    <h2 class="text-sm font-semibold text-gray-100 mb-4">Mis datos</h2>
    <div class="grid sm:grid-cols-2 gap-4 text-sm">
        <div><span class="text-gray-500">Nombre:</span> <span class="text-gray-200">{{ $user->name }}</span></div>
        <div><span class="text-gray-500">Email:</span> <span class="text-gray-200">{{ $user->email }}</span></div>
        @if($cliente)
        <div><span class="text-gray-500">CI / NIT:</span> <span class="text-gray-200">{{ $cliente->ci_nit }}</span></div>
        <div><span class="text-gray-500">Telefono:</span> <span class="text-gray-200">{{ $cliente->telefono }}</span></div>
        @endif
    </div>
</div>
@endsection

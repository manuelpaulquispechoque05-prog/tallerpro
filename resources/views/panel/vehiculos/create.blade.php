@extends('layouts.panel')
@section('title', 'Nuevo vehiculo')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-9 h-9 rounded-lg bg-blue-500/10 flex items-center justify-center">
                <svg class="w-4.5 h-4.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <h1 class="text-sm font-semibold text-gray-100">Nuevo vehiculo</h1>
                @if($citaId)
                    <p class="text-xs text-blue-400 mt-0.5">Asociado a cita #{{ $citaId }}</p>
                @else
                    <p class="text-xs text-gray-500 mt-0.5">Registra un vehiculo en el sistema</p>
                @endif
            </div>
        </div>

        @if($citaInfo)
        <div class="p-4 mb-6 rounded-xl bg-blue-500/5 border border-blue-500/10">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Referencia de la cita</p>
            <div class="grid sm:grid-cols-2 gap-2 text-sm">
                <div><span class="text-gray-500">Cliente:</span> <span class="text-gray-200">{{ $citaInfo->cliente?->nombre_completo }}</span></div>
                <div><span class="text-gray-500">Tipo de vehiculo:</span> <span class="text-gray-200">{{ $citaInfo->tipoVehiculo?->nombre ?? '—' }}</span></div>
                @if($citaInfo->servicio)
                <div><span class="text-gray-500">Servicio:</span> <span class="text-gray-200">{{ $citaInfo->servicio->nombre }}</span></div>
                @endif
                <div><span class="text-gray-500">Fecha:</span> <span class="text-gray-200">{{ $citaInfo->fecha_hora?->format('d/m/Y H:i') }}</span></div>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('panel.vehiculos.store') }}">
            @csrf
            @if($citaId)
                <input type="hidden" name="cita_id" value="{{ $citaId }}">
            @endif
            @include('panel.vehiculos.form', ['vehiculo' => null])
        </form>
    </div>
</div>
@endsection

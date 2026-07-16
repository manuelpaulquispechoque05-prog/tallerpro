@extends('layouts.portal')
@section('title', 'Mis citas')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-white">Mis citas</h1>
        <p class="text-sm text-gray-400 mt-1">Historial de citas agendadas</p>
    </div>
    <a href="{{ route('portal.citas.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nueva cita
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400">{{ session('success') }}</div>
@endif

@if($citas->count() > 0)
<div class="space-y-3">
    @foreach($citas as $c)
    @php
        $colores = [
            'pendiente' => ['border' => 'border-l-yellow-500', 'bg' => 'bg-yellow-500/10', 'text' => 'text-yellow-400'],
            'confirmada' => ['border' => 'border-l-blue-500', 'bg' => 'bg-blue-500/10', 'text' => 'text-blue-400'],
            'asignada' => ['border' => 'border-l-purple-500', 'bg' => 'bg-purple-500/10', 'text' => 'text-purple-400'],
            'atendida' => ['border' => 'border-l-green-500', 'bg' => 'bg-green-500/10', 'text' => 'text-green-400'],
            'cancelada' => ['border' => 'border-l-gray-500', 'bg' => 'bg-gray-500/10', 'text' => 'text-gray-400'],
        ];
        $co = $colores[$c->estado] ?? $colores['pendiente'];
    @endphp
    <div class="glass-card rounded-2xl border-l-4 {{ $co['border'] }} p-4 sm:p-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="text-center">
                    <p class="text-lg font-bold text-white leading-tight">{{ $c->fecha_hora?->format('d') }}</p>
                    <p class="text-xs text-gray-500">{{ $c->fecha_hora?->format('M') }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-100">{{ $c->servicio?->nombre ?? '—' }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $c->fecha_hora?->format('H:i') }} • {{ $c->duracion_minutos }} min</p>
                    @if($c->vehiculo)
                        <p class="text-xs text-gray-600 font-mono mt-0.5">{{ $c->vehiculo->placa }}</p>
                    @else
                        <p class="text-xs text-gray-600 mt-0.5">{{ $c->tipoVehiculo?->nombre ?? '—' }}</p>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium {{ $co['bg'] }} {{ $co['text'] }}">
                    {{ ucfirst($c->estado) }}
                </span>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="glass-card rounded-2xl p-10 text-center">
    <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
    <p class="text-sm text-gray-500">No tienes citas agendadas</p>
    <a href="{{ route('portal.citas.create') }}" class="inline-block mt-3 text-sm text-blue-400 hover:text-blue-300 transition">Reservar una cita</a>
</div>
@endif
@endsection

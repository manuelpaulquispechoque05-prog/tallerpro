@extends('layouts.panel')
@section('title', 'Cita #' . $cita->id)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8 mb-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-2xl font-bold shadow-xl shadow-blue-500/20 shrink-0">
                #{{ $cita->id }}
            </div>
            <div class="text-center sm:text-left flex-1">
                <h1 class="text-xl font-bold text-white">Cita #{{ $cita->id }}</h1>
                <p class="text-sm text-gray-400 mt-1">{{ $cita->cliente?->nombre_completo ?? '—' }}</p>
                <div class="flex flex-wrap gap-2 mt-3 justify-center sm:justify-start">
                    @php
                        $colores = [
                            'pendiente' => 'bg-yellow-500/10 text-yellow-400',
                            'confirmada' => 'bg-blue-500/10 text-blue-400',
                            'asignada' => 'bg-purple-500/10 text-purple-400',
                            'atendida' => 'bg-green-500/10 text-green-400',
                            'cancelada' => 'bg-gray-500/10 text-gray-400',
                        ];
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium {{ $colores[$cita->estado] ?? '' }}">
                        {{ ucfirst($cita->estado) }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400">
                        {{ $cita->tipo_solicitud === 'servicio' ? 'Servicio' : 'Diagnostico' }}
                    </span>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 shrink-0 justify-center">
                @if($cita->estado === 'pendiente')
                    <a href="{{ route('panel.citas.confirmar', $cita->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-blue-500/25" onclick="return confirm('Confirmar esta cita?')">Confirmar cita</a>
                @endif
                @if(in_array($cita->estado, ['pendiente', 'confirmada']))
                    <a href="{{ route('panel.citas.cancelar', $cita->id) }}" class="inline-flex items-center px-4 py-2 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-400 text-xs font-medium rounded-full transition" onclick="return confirm('Cancelar esta cita?')">Cancelar</a>
                @endif
                @if($cita->estado === 'asignada')
                    @if($cita->vehiculo_id)
                        <a href="{{ route('panel.citas.crear-orden', $cita->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-green-500/25">Crear orden</a>
                    @else
                        <a href="{{ route('panel.vehiculos.create', ['cliente_id' => $cita->cliente_id, 'cita_id' => $cita->id]) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-amber-500/25">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Registrar vehiculo
                        </a>
                    @endif
                @endif
                <a href="{{ route('panel.citas.index') }}" class="inline-flex items-center px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-xs font-medium rounded-full transition">Volver</a>
            </div>
        </div>
    </div>

    <!-- Info -->
    <div class="grid lg:grid-cols-2 gap-4 mb-6">
        <div class="animate-in animate-in-d2 glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-sm font-semibold text-gray-100 mb-4">Detalles de la cita</h2>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Cliente</span>
                    <span class="text-sm text-gray-200">{{ $cita->cliente?->nombre_completo ?? '—' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Tipo de solicitud</span>
                    <span class="text-sm text-gray-200">{{ $cita->tipo_solicitud === 'servicio' ? 'Servicio' : 'Diagnostico' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Servicio</span>
                    <span class="text-sm text-gray-200">{{ $cita->servicio?->nombre ?? '—' }}</span>
                </div>
                @if($cita->descripcion_problema)
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Problema descrito</span>
                    <span class="text-sm text-gray-200">{{ $cita->descripcion_problema }}</span>
                </div>
                @endif
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Vehiculo</span>
                    <span class="text-sm text-gray-200">{{ $cita->tipoVehiculo?->nombre ?? '—' }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-xs text-gray-500">Duracion estimada</span>
                    <span class="text-sm text-gray-200">{{ $cita->duracion_minutos }} min</span>
                </div>
            </div>
        </div>

        <div class="animate-in animate-in-d3 glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-sm font-semibold text-gray-100 mb-4">Agenda</h2>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Fecha</span>
                    <span class="text-sm text-gray-200">{{ $cita->fecha_hora?->format('d/m/Y') ?? '—' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Hora</span>
                    <span class="text-sm text-gray-200">{{ $cita->fecha_hora?->format('H:i') ?? '—' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Mecanico asignado</span>
                    <span class="text-sm text-gray-200">{{ $cita->mecanico?->nombre_completo ?? 'Pendiente' }}</span>
                </div>
                @if($cita->ordenTrabajo)
                <div class="flex justify-between py-2">
                    <span class="text-xs text-gray-500">Orden de trabajo</span>
                    <span class="text-sm text-blue-400">#{{ $cita->ordenTrabajo->id }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Asignar mecanico -->
    @if(in_array($cita->estado, ['pendiente', 'confirmada']))
    <div class="animate-in animate-in-d4 glass-card rounded-2xl p-5 lg:p-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Asignar mecanico</h2>
        <form method="POST" action="{{ route('panel.citas.asignar-mecanico', $cita->id) }}" class="flex flex-col sm:flex-row gap-3 items-end">
            @csrf
            <div class="flex-1 w-full">
                <select name="mecanico_id" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                    <option value="" class="bg-[#1a1a1a]">Seleccionar mecanico</option>
                    @foreach($mecanicos as $m)
                        <option value="{{ $m->id }}" class="bg-[#1a1a1a]">{{ $m->nombre_completo }} ({{ $m->especialidad?->nombre ?? 'Gral' }})</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 w-full sm:w-auto cursor-pointer">Asignar</button>
        </form>
        @error('mecanico_id')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>
    @endif
</div>
@endsection

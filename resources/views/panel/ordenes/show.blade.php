@extends('layouts.panel')
@section('title', 'Orden #' . $orden->id)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8 mb-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-2xl font-bold shadow-xl shadow-blue-500/20 shrink-0">
                #{{ $orden->id }}
            </div>
            <div class="text-center sm:text-left flex-1">
                <h1 class="text-xl font-bold text-white">Orden de trabajo #{{ $orden->id }}</h1>
                <p class="text-sm text-gray-400 mt-1">{{ $orden->cliente?->nombre_completo ?? '—' }}</p>
                <div class="flex flex-wrap gap-2 mt-3 justify-center sm:justify-start">
                    @php
                        $colores = [
                            'pendiente' => 'bg-yellow-500/10 text-yellow-400',
                            'en_proceso' => 'bg-blue-500/10 text-blue-400',
                            'completado' => 'bg-green-500/10 text-green-400',
                            'cancelado' => 'bg-gray-500/10 text-gray-400',
                        ];
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium {{ $colores[$orden->estado] ?? '' }}">{{ ucfirst($orden->estado) }}</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400">{{ $orden->vehiculo?->placa ?? 'Sin vehiculo' }}</span>
                </div>
            </div>
            <a href="{{ route('panel.ordenes.index') }}" class="inline-flex items-center px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-xs font-medium rounded-full transition shrink-0">Volver</a>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-4 mb-6">
        <div class="animate-in animate-in-d2 glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-sm font-semibold text-gray-100 mb-4">Informacion general</h2>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Cliente</span>
                    <span class="text-sm text-gray-200">{{ $orden->cliente?->nombre_completo ?? '—' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Vehiculo</span>
                    <span class="text-sm text-gray-200">{{ $orden->vehiculo?->placa ?? '—' }} ({{ $orden->vehiculo?->marca?->nombre ?? '' }} {{ $orden->vehiculo?->modelo?->nombre ?? '' }})</span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Kilometraje</span>
                    <span class="text-sm text-gray-200">{{ number_format($orden->kilometraje_ingreso) }} km</span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Mecanico</span>
                    <span class="text-sm text-gray-200">{{ $orden->mecanico?->user?->name ?? '—' }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-xs text-gray-500">Creado por</span>
                    <span class="text-sm text-gray-200">{{ $orden->creador?->name ?? '—' }}</span>
                </div>
            </div>
        </div>

        <div class="animate-in animate-in-d3 glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-sm font-semibold text-gray-100 mb-4">Fechas y total</h2>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Fecha de ingreso</span>
                    <span class="text-sm text-gray-200">{{ $orden->fecha_ingreso?->format('d/m/Y H:i') ?? '—' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Entrega estimada</span>
                    <span class="text-sm text-gray-200">{{ $orden->fecha_estimada_entrega?->format('d/m/Y') ?? '—' }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-xs text-gray-500">Total</span>
                    <span class="text-lg font-bold text-white">${{ number_format($orden->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    @if($orden->observaciones)
    <div class="animate-in animate-in-d4 glass-card rounded-2xl p-5 lg:p-6 mb-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-3">Observaciones</h2>
        <p class="text-sm text-gray-400 leading-relaxed">{{ $orden->observaciones }}</p>
    </div>
    @endif

    <!-- Servicios -->
    @if($orden->detalleServicios->count() > 0)
    <div class="animate-in animate-in-d5 glass-card rounded-2xl p-5 lg:p-6 mb-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Servicios</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/[0.04]">
                        <th class="px-4 py-2.5 text-left text-[10px] font-semibold uppercase text-gray-600">Servicio</th>
                        <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Precio</th>
                        <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Cant</th>
                        <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orden->detalleServicios as $d)
                    <tr class="border-b border-white/[0.03]">
                        <td class="px-4 py-3 text-gray-300">{{ $d->servicio?->nombre ?? '—' }}</td>
                        <td class="px-4 py-3 text-right text-gray-400">${{ number_format($d->precio_unitario, 2) }}</td>
                        <td class="px-4 py-3 text-right text-gray-400">{{ $d->cantidad }}</td>
                        <td class="px-4 py-3 text-right text-gray-200 font-medium">${{ number_format($d->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($orden->detalleRepuestos->count() > 0)
    <div class="animate-in animate-in-d6 glass-card rounded-2xl p-5 lg:p-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Repuestos</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/[0.04]">
                        <th class="px-4 py-2.5 text-left text-[10px] font-semibold uppercase text-gray-600">Repuesto</th>
                        <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Precio</th>
                        <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Cant</th>
                        <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orden->detalleRepuestos as $d)
                    <tr class="border-b border-white/[0.03]">
                        <td class="px-4 py-3 text-gray-300">{{ $d->repuesto?->nombre ?? '—' }}</td>
                        <td class="px-4 py-3 text-right text-gray-400">${{ number_format($d->precio_unitario, 2) }}</td>
                        <td class="px-4 py-3 text-right text-gray-400">{{ $d->cantidad }}</td>
                        <td class="px-4 py-3 text-right text-gray-200 font-medium">${{ number_format($d->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

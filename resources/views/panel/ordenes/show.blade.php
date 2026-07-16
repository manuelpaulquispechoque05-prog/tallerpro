@extends('layouts.panel')
@section('title', 'Orden #' . $orden->id)

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8 mb-6">
        <div class="flex flex-col sm:flex-row items-start justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shrink-0">#{{ $orden->id }}</div>
                <div>
                    <h1 class="text-xl font-bold text-white">Orden de trabajo #{{ $orden->id }}</h1>
                    <p class="text-sm text-gray-400 mt-0.5">{{ $orden->cliente?->nombre_completo ?? '—' }}</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @php
                            $colEst = ['pendiente' => 'bg-yellow-500/10 text-yellow-400', 'en_proceso' => 'bg-blue-500/10 text-blue-400', 'completado' => 'bg-green-500/10 text-green-400', 'cancelado' => 'bg-gray-500/10 text-gray-400'];
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium {{ $colEst[$orden->estado] ?? '' }}">{{ ucfirst($orden->estado) }}</span>
                        <span class="text-xs text-gray-500 font-mono">{{ $orden->vehiculo?->placa ?? '—' }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                @if($orden->estado === 'pendiente')
                    <form method="POST" action="{{ route('panel.ordenes.iniciar', $orden->id) }}" class="inline">@csrf<button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">Iniciar trabajo</button></form>
                    <form method="POST" action="{{ route('panel.ordenes.cancelar', $orden->id) }}" onsubmit="return confirm('Cancelar esta orden?')" class="inline">@csrf<button type="submit" class="px-4 py-2 bg-white/5 border border-white/10 text-gray-300 text-xs font-medium rounded-full transition cursor-pointer">Cancelar</button></form>
                @endif
                @if($orden->estado === 'en_proceso')
                    <form method="POST" action="{{ route('panel.ordenes.completar', $orden->id) }}" onsubmit="return confirm('Marcar como completada?')" class="inline">@csrf<button type="submit" class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-green-500/25 cursor-pointer">Completar</button></form>
                @endif
                <a href="{{ route('panel.ordenes.index') }}" class="px-4 py-2 bg-white/5 border border-white/10 text-gray-300 text-xs font-medium rounded-full transition">Volver</a>
            </div>
        </div>
    </div>

    @if(session('success'))<div class="mb-6 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="mb-6 p-3 bg-red-500/10 border border-red-500/20 rounded-xl text-sm text-red-400">{{ session('error') }}</div>@endif

    <!-- Info -->
    <div class="grid lg:grid-cols-2 gap-4 mb-6">
        <div class="animate-in animate-in-d2 glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-sm font-semibold text-gray-100 mb-4">Informacion general</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-white/[0.04]"><span class="text-gray-500">Cliente</span><span class="text-gray-200">{{ $orden->cliente?->nombre_completo ?? '—' }}</span></div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]"><span class="text-gray-500">Vehiculo</span><span class="text-gray-200">{{ $orden->vehiculo?->placa ?? '—' }} ({{ $orden->vehiculo?->marca?->nombre ?? '' }} {{ $orden->vehiculo?->modelo?->nombre ?? '' }})</span></div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]"><span class="text-gray-500">Mecanico</span><span class="text-gray-200">{{ $orden->mecanico?->nombre_completo ?? '—' }}</span></div>
                <div class="flex justify-between py-2"><span class="text-gray-500">Creado por</span><span class="text-gray-200">{{ $orden->creador?->name ?? '—' }}</span></div>
            </div>
        </div>
        <div class="animate-in animate-in-d3 glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-sm font-semibold text-gray-100 mb-4">Fechas y total</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-white/[0.04]"><span class="text-gray-500">Ingreso</span><span class="text-gray-200">{{ $orden->fecha_ingreso?->format('d/m/Y H:i') ?? '—' }}</span></div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]"><span class="text-gray-500">Entrega estimada</span><span class="text-gray-200">{{ $orden->fecha_estimada_entrega?->format('d/m/Y') ?? '—' }}</span></div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]"><span class="text-gray-500">Finalizada</span><span class="text-gray-200">{{ $orden->fecha_entrega?->format('d/m/Y H:i') ?? '—' }}</span></div>
                <div class="flex justify-between pt-2"><span class="text-gray-500">Total</span><span class="text-lg font-bold text-white">Bs {{ number_format($orden->total, 2) }}</span></div>
            </div>
        </div>
    </div>

    @if($orden->observaciones)
    <div class="animate-in animate-in-d4 glass-card rounded-2xl p-5 lg:p-6 mb-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-2">Observaciones</h2>
        <p class="text-sm text-gray-400">{{ $orden->observaciones }}</p>
    </div>
    @endif

    <!-- Servicios -->
    <div class="animate-in animate-in-d5 glass-card rounded-2xl p-5 lg:p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-100">Servicios</h2>
            @if(!in_array($orden->estado, ['completado', 'cancelado']))
            <form method="POST" action="{{ route('panel.ordenes.servicios.store', $orden->id) }}" class="flex gap-2 items-end">
                @csrf
                <div>
                    <select name="servicio_id" required class="px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <option value="" class="bg-[#1a1a1a]">Agregar servicio</option>
                        @foreach($servicios as $s)<option value="{{ $s->id }}" class="bg-[#1a1a1a]">{{ $s->nombre }}</option>@endforeach
                    </select>
                </div>
                <button type="submit" class="px-3 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-semibold rounded-xl transition cursor-pointer">Agregar</button>
            </form>
            @endif
        </div>
        @if($orden->detalleServicios->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b border-white/[0.04]">
                    <th class="px-4 py-2.5 text-left text-[10px] font-semibold uppercase text-gray-600">Servicio</th>
                    <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Precio</th>
                    <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Cant</th>
                    <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Subtotal</th>
                    @if(!in_array($orden->estado, ['completado', 'cancelado']))<th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Accion</th>@endif
                </tr></thead>
                <tbody>
                    @foreach($orden->detalleServicios as $d)
                    <tr class="border-b border-white/[0.03]">
                        <td class="px-4 py-3 text-gray-300">{{ $d->servicio?->nombre ?? '—' }}</td>
                        <td class="px-4 py-3 text-right text-gray-400">Bs {{ number_format($d->precio_unitario, 2) }}</td>
                        <td class="px-4 py-3 text-right text-gray-400">{{ $d->cantidad }}</td>
                        <td class="px-4 py-3 text-right text-gray-200 font-medium">Bs {{ number_format($d->subtotal, 2) }}</td>
                        @if(!in_array($orden->estado, ['completado', 'cancelado']))
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('panel.ordenes.servicios.destroy', [$orden->id, $d->id]) }}" onsubmit="return confirm('Eliminar este servicio?')" class="inline">@csrf @method('DELETE')<button type="submit" class="text-xs text-red-400 hover:text-red-300 transition cursor-pointer">Eliminar</button></form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-sm text-gray-500 text-center py-4">Sin servicios registrados</p>
        @endif
    </div>

    <!-- Repuestos -->
    <div class="animate-in animate-in-d6 glass-card rounded-2xl p-5 lg:p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-100">Repuestos</h2>
            @if(!in_array($orden->estado, ['completado', 'cancelado']))
            <form method="POST" action="{{ route('panel.ordenes.repuestos.store', $orden->id) }}" class="flex gap-2 items-end">
                @csrf
                <div><select name="repuesto_id" required class="px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50"><option value="" class="bg-[#1a1a1a]">Agregar repuesto</option>@foreach($repuestos as $r)<option value="{{ $r->id }}" class="bg-[#1a1a1a]">{{ $r->nombre }} (Bs {{ number_format($r->precio_venta, 2) }})</option>@endforeach</select></div>
                <div><input name="cantidad" type="number" min="1" value="1" class="w-16 px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-xs text-white"></div>
                <button type="submit" class="px-3 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-semibold rounded-xl transition cursor-pointer">Agregar</button>
            </form>
            @endif
        </div>
        @if($orden->detalleRepuestos->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b border-white/[0.04]">
                    <th class="px-4 py-2.5 text-left text-[10px] font-semibold uppercase text-gray-600">Repuesto</th>
                    <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Precio</th>
                    <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Cant</th>
                    <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Subtotal</th>
                    @if(!in_array($orden->estado, ['completado', 'cancelado']))<th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Accion</th>@endif
                </tr></thead>
                <tbody>
                    @foreach($orden->detalleRepuestos as $d)
                    <tr class="border-b border-white/[0.03]">
                        <td class="px-4 py-3 text-gray-300">{{ $d->repuesto?->nombre ?? '—' }}</td>
                        <td class="px-4 py-3 text-right text-gray-400">Bs {{ number_format($d->precio_unitario, 2) }}</td>
                        <td class="px-4 py-3 text-right text-gray-400">{{ $d->cantidad }}</td>
                        <td class="px-4 py-3 text-right text-gray-200 font-medium">Bs {{ number_format($d->subtotal, 2) }}</td>
                        @if(!in_array($orden->estado, ['completado', 'cancelado']))
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('panel.ordenes.repuestos.destroy', [$orden->id, $d->id]) }}" onsubmit="return confirm('Eliminar este repuesto?')" class="inline">@csrf @method('DELETE')<button type="submit" class="text-xs text-red-400 hover:text-red-300 transition cursor-pointer">Eliminar</button></form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-sm text-gray-500 text-center py-4">Sin repuestos registrados</p>
        @endif
    </div>
</div>
@endsection

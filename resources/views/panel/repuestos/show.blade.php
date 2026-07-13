@extends('layouts.panel')
@section('title', $repuesto->nombre)
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shrink-0">
                {{ substr($repuesto->nombre, 0, 1) }}
            </div>
            <div class="flex-1">
                <h1 class="text-xl font-bold text-white">{{ $repuesto->nombre }}</h1>
                <p class="text-sm text-gray-400 mt-0.5">Codigo: <span class="font-mono text-gray-300">{{ $repuesto->codigo }}</span></p>
            </div>
            <a href="{{ route('panel.repuestos.edit', $repuesto->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-blue-500/25">Editar</a>
            <a href="{{ route('panel.repuestos.index') }}" class="inline-flex items-center px-4 py-2 bg-white/5 border border-white/10 text-gray-300 text-xs font-medium rounded-full transition">Volver</a>
        </div>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div class="glass-card rounded-2xl p-5">
            <h2 class="text-sm font-semibold text-gray-100 mb-3">Informacion</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between py-1.5 border-b border-white/[0.04]"><span class="text-gray-500">Categoria</span><span class="text-gray-200">{{ $repuesto->categoria?->nombre ?? '—' }}</span></div>
                <div class="flex justify-between py-1.5 border-b border-white/[0.04]"><span class="text-gray-500">Proveedor</span><span class="text-gray-200">{{ $repuesto->proveedor?->nombre ?? '—' }}</span></div>
                <div class="flex justify-between py-1.5 border-b border-white/[0.04]"><span class="text-gray-500">Precio compra</span><span class="text-gray-200">${{ number_format($repuesto->precio_compra, 2) }}</span></div>
                <div class="flex justify-between py-1.5 border-b border-white/[0.04]"><span class="text-gray-500">Precio venta</span><span class="text-gray-200">${{ number_format($repuesto->precio_venta, 2) }}</span></div>
                <div class="flex justify-between py-1.5"><span class="text-gray-500">Unidad</span><span class="text-gray-200">{{ $repuesto->unidad_medida }}</span></div>
            </div>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <h2 class="text-sm font-semibold text-gray-100 mb-3">Inventario</h2>
            @if($repuesto->inventario)
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between py-1.5 border-b border-white/[0.04]"><span class="text-gray-500">Stock actual</span>
                        <span class="{{ $repuesto->inventario->stock_actual <= $repuesto->inventario->stock_minimo ? 'text-red-400 font-semibold' : 'text-green-400' }}">{{ $repuesto->inventario->stock_actual }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-white/[0.04]"><span class="text-gray-500">Stock minimo</span><span class="text-gray-200">{{ $repuesto->inventario->stock_minimo }}</span></div>
                    <div class="flex justify-between py-1.5"><span class="text-gray-500">Sucursal</span><span class="text-gray-200">{{ $repuesto->inventario->sucursal?->nombre ?? '—' }}</span></div>
                </div>
                @if($repuesto->inventario->stock_actual <= $repuesto->inventario->stock_minimo)
                    <div class="mt-3 p-2 bg-red-500/10 border border-red-500/20 rounded-lg text-xs text-red-400 text-center">Stock bajo — solicitar reposicion</div>
                @endif
            @else
                <p class="text-sm text-gray-500">Sin registro en inventario</p>
            @endif
        </div>
        @if($repuesto->descripcion)
        <div class="sm:col-span-2 glass-card rounded-2xl p-5">
            <h2 class="text-sm font-semibold text-gray-100 mb-2">Descripcion</h2>
            <p class="text-sm text-gray-400">{{ $repuesto->descripcion }}</p>
        </div>
        @endif
    </div>
</div>
@endsection

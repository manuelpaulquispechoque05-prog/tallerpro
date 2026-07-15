@extends('layouts.panel')
@section('title', 'Repuestos')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="flex-1">
        <form method="GET" x-data>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar repuesto..." class="w-full pl-10 pr-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" x-on:input.debounce.500ms="$el.form.submit()">
            </div>
        </form>
    </div>
    <a href="{{ route('panel.repuestos.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-blue-500/25 shrink-0">Nuevo repuesto</a>
</div>

@if(session('success'))<div class="mb-6 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400">{{ session('success') }}</div>@endif

<!-- Catalog Grid -->
@if($repuestos->count() > 0)
<div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @foreach($repuestos as $r)
    @php $inv = $r->inventario; $alerta = $inv && $inv->stock_actual <= $inv->stock_minimo; @endphp
    <div class="glass-card rounded-2xl overflow-hidden hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-300 group">
        <div class="aspect-[4/3] bg-gradient-to-br from-gray-800/50 to-gray-900/50 flex items-center justify-center relative">
            <svg class="w-16 h-16 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <div class="absolute top-2 right-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium {{ $r->activo ? 'bg-green-500/10 text-green-400' : 'bg-gray-500/10 text-gray-400' }}">{{ $r->activo ? 'Activo' : 'Inactivo' }}</span>
            </div>
        </div>
        <div class="p-4">
            <p class="text-xs font-mono text-gray-600 mb-1">{{ $r->codigo }}</p>
            <h4 class="text-sm font-semibold text-gray-100 leading-tight">{{ $r->nombre }}</h4>
            <div class="mt-2 flex flex-wrap gap-1.5">
                <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-500/10 text-blue-400">{{ $r->categoria?->nombre ?? 'General' }}</span>
                <span class="text-[10px] px-2 py-0.5 rounded-full bg-gray-500/10 text-gray-400">{{ $r->proveedor?->nombre ?? '—' }}</span>
            </div>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-sm font-bold text-white">${{ number_format($r->precio_venta, 2) }}</span>
                @if($inv)
                    <span class="text-xs font-medium {{ $alerta ? 'text-red-400' : 'text-green-400' }}">{{ $inv->stock_actual }} en stock</span>
                @else
                    <span class="text-xs text-gray-600">Sin stock</span>
                @endif
            </div>
            <div class="mt-3 pt-3 border-t border-white/[0.06] flex items-center justify-between">
                <a href="{{ route('panel.repuestos.show', $r->id) }}" class="text-xs text-blue-400 hover:text-blue-300 transition">Ver detalle</a>
                <div class="flex gap-1">
                    <a href="{{ route('panel.repuestos.edit', $r->id) }}" class="p-1.5 rounded-lg hover:bg-white/10 transition text-gray-500 hover:text-yellow-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                    <form method="POST" action="{{ route('panel.repuestos.destroy', $r->id) }}" onsubmit="return confirm('Eliminar?')" class="inline">@csrf @method('DELETE')<button type="submit" class="p-1.5 rounded-lg hover:bg-white/10 transition text-gray-500 hover:text-red-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="glass-card rounded-2xl p-10 text-center">
    <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
    <p class="text-sm text-gray-500">No hay repuestos registrados</p>
</div>
@endif

@if($repuestos->hasPages())<div class="mt-6">{{ $repuestos->links() }}</div>@endif
@endsection

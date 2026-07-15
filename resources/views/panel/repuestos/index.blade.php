@extends('layouts.panel')
@section('title', 'Repuestos e Inventario')

@section('content')
<div class="glass-card rounded-2xl overflow-hidden shadow-xl shadow-black/20">
    <div class="px-5 lg:px-6 py-5 border-b border-white/[0.06] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Catálogo de Repuestos
            </h3>
            <p class="text-xs text-gray-400 mt-1">Inventario general y control de stock de piezas.</p>
        </div>
        <a href="{{ route('panel.repuestos.create') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-400 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(79,70,229,0.4)] hover:shadow-[0_0_25px_rgba(79,70,229,0.6)] hover:-translate-y-0.5">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Añadir Pieza
        </a>
    </div>

    <div class="px-5 lg:px-6 py-4 border-b border-white/[0.06] bg-white/[0.01]">
        <form method="GET" x-data>
            <div class="relative max-w-md">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar por código (SKU), nombre o proveedor..." class="w-full pl-10 pr-4 py-2.5 bg-white/[0.03] border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner" x-on:input.debounce.500ms="$el.form.submit()">
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="mx-5 lg:mx-6 mt-4 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center gap-3">
            <div class="p-1.5 bg-emerald-500/20 rounded-lg text-emerald-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="text-sm font-medium text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-white/[0.02] border-b border-white/[0.04]">
                    <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Info. Pieza</th>
                    <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Proveedor / Categoria</th>
                    <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500 w-48">Nivel de Stock</th>
                    <th class="px-5 py-4 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">Precio (USD)</th>
                    <th class="px-5 py-4 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/[0.02]">
                @forelse($repuestos as $r)
                    <tr class="hover:bg-white/[0.03] transition-colors group">
                        <td class="px-5 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm text-white font-bold">{{ $r->nombre }}</span>
                                <span class="inline-flex items-center gap-1 text-[10px] font-mono text-indigo-400 bg-indigo-500/10 px-1.5 py-0.5 rounded w-fit mt-1 border border-indigo-500/20">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    {{ $r->codigo }}
                                </span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-1.5 text-sm text-gray-300">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    {{ $r->proveedor?->nombre ?? 'Sin proveedor' }}
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                    <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                    {{ $r->categoria?->nombre ?? 'Sin categoría' }}
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @php 
                                $inv = $r->inventario; 
                                $stock = $inv ? $inv->stock_actual : 0;
                                $min = $inv ? $inv->stock_minimo : 0;
                                $isLow = $inv && $stock <= $min;
                                $percent = $min > 0 ? min(100, ($stock / ($min * 3)) * 100) : ($stock > 0 ? 100 : 0);
                            @endphp
                            
                            @if($inv)
                                <div class="flex flex-col gap-1.5 w-full max-w-[180px]">
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="font-bold {{ $isLow ? 'text-rose-400' : 'text-emerald-400' }}">{{ $stock }} <span class="text-gray-500 font-normal">/ min {{ $min }}</span></span>
                                        @if($isLow)
                                            <span class="text-[9px] font-bold text-rose-500 bg-rose-500/10 px-1.5 py-0.5 rounded uppercase">Bajo</span>
                                        @endif
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $isLow ? 'bg-rose-500' : 'bg-emerald-500' }} shadow-[0_0_8px_currentColor]" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            @else
                                <span class="inline-flex items-center px-2 py-1 bg-white/5 rounded text-xs text-gray-500 border border-white/10">Sin inventario</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="inline-flex flex-col items-end">
                                <span class="text-lg font-black text-emerald-400 drop-shadow-[0_0_8px_rgba(16,185,129,0.2)]">${{ number_format($r->precio_venta, 2) }}</span>
                                @if($r->precio_compra)
                                    <span class="text-[10px] text-gray-500">Costo: ${{ number_format($r->precio_compra, 2) }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('panel.repuestos.show', $r->id) }}" class="p-2 rounded-lg bg-white/5 hover:bg-indigo-500/20 hover:text-indigo-400 border border-transparent hover:border-indigo-500/30 text-gray-400 transition-all" title="Ver detalle">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('panel.repuestos.edit', $r->id) }}" class="p-2 rounded-lg bg-white/5 hover:bg-yellow-500/20 hover:text-yellow-400 border border-transparent hover:border-yellow-500/30 text-gray-400 transition-all" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('panel.repuestos.destroy', $r->id) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este repuesto?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-white/5 hover:bg-red-500/20 hover:text-red-400 border border-transparent hover:border-red-500/30 text-gray-400 transition-all" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 mb-4 border border-white/10">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <p class="text-sm font-medium text-gray-400">No hay repuestos registrados</p>
                            <p class="text-xs text-gray-500 mt-1 mb-4">Comienza registrando la primera pieza en el catálogo.</p>
                            <a href="{{ route('panel.repuestos.create') }}" class="inline-flex items-center px-4 py-2 border border-indigo-500/50 text-indigo-400 text-xs font-semibold rounded-full hover:bg-indigo-500/10 transition-colors">
                                Registrar repuesto
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($repuestos->hasPages())
        <div class="px-5 lg:px-6 py-4 border-t border-white/[0.06] bg-white/[0.01]">
            {{ $repuestos->links() }}
        </div>
    @endif
</div>
@endsection

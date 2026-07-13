@extends('layouts.panel')
@section('title', 'Repuestos')

@section('content')
<div class="glass-card rounded-2xl overflow-hidden">
    <div class="px-5 lg:px-6 py-4 border-b border-white/[0.06] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h3 class="text-sm font-semibold text-gray-100">Repuestos</h3>
            <p class="text-xs text-gray-500 mt-0.5">Catalogo de repuestos del taller</p>
        </div>
        <a href="{{ route('panel.repuestos.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-blue-500/25">
            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo repuesto
        </a>
    </div>

    <div class="px-5 lg:px-6 py-3 border-b border-white/[0.06]">
        <form method="GET" x-data>
            <div class="relative max-w-md">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar por nombre, codigo o proveedor..." class="w-full pl-10 pr-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" x-on:input.debounce.500ms="$el.form.submit()">
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="mx-5 lg:mx-6 mt-4 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/[0.04]">
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Codigo</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Nombre</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Categoria</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Proveedor</th>
                    <th class="px-5 py-3.5 text-right text-[10px] font-semibold uppercase text-gray-600">P. Venta</th>
                    <th class="px-5 py-3.5 text-center text-[10px] font-semibold uppercase text-gray-600">Stock</th>
                    <th class="px-5 py-3.5 text-center text-[10px] font-semibold uppercase text-gray-600">Estado</th>
                    <th class="px-5 py-3.5 text-right text-[10px] font-semibold uppercase text-gray-600">Accion</th>
                </tr>
            </thead>
            <tbody>
                @forelse($repuestos as $r)
                    <tr class="border-b border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 font-mono text-xs text-gray-500">{{ $r->codigo }}</td>
                        <td class="px-5 py-4 text-sm text-gray-200 font-medium">{{ $r->nombre }}</td>
                        <td class="px-5 py-4 text-sm text-gray-400">{{ $r->categoria?->nombre ?? '—' }}</td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $r->proveedor?->nombre ?? '—' }}</td>
                        <td class="px-5 py-4 text-right text-sm font-medium text-gray-200">${{ number_format($r->precio_venta, 2) }}</td>
                        <td class="px-5 py-4 text-center">
                            @php $inv = $r->inventario; @endphp
                            @if($inv && $inv->stock_actual <= $inv->stock_minimo)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                    {{ $inv->stock_actual }}
                                </span>
                            @elseif($inv)
                                <span class="text-sm text-gray-400">{{ $inv->stock_actual }}</span>
                            @else
                                <span class="text-xs text-gray-600">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $r->activo ? 'bg-green-500/10 text-green-400' : 'bg-gray-500/10 text-gray-400' }}">
                                {{ $r->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('panel.repuestos.show', $r->id) }}" class="p-2 rounded-lg hover:bg-white/10 transition text-gray-400 hover:text-blue-400" title="Ver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('panel.repuestos.edit', $r->id) }}" class="p-2 rounded-lg hover:bg-white/10 transition text-gray-400 hover:text-yellow-400" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('panel.repuestos.destroy', $r->id) }}" onsubmit="return confirm('Eliminar este repuesto?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg hover:bg-white/10 transition text-gray-400 hover:text-red-400" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-5 py-10 text-center text-sm text-gray-500">No hay repuestos registrados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($repuestos->hasPages())
        <div class="px-5 lg:px-6 py-4 border-t border-white/[0.06]">{{ $repuestos->links() }}</div>
    @endif
</div>
@endsection

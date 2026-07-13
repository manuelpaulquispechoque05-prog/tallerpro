@extends('layouts.panel')
@section('title', 'Movimientos de inventario')

@section('content')
<div class="glass-card rounded-2xl overflow-hidden">
    <div class="px-5 lg:px-6 py-4 border-b border-white/[0.06]">
        <h3 class="text-sm font-semibold text-gray-100">Movimientos de inventario</h3>
        <p class="text-xs text-gray-500 mt-0.5">Ultimos movimientos registrados</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/[0.04]">
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Repuesto</th>
                    <th class="px-5 py-3.5 text-center text-[10px] font-semibold uppercase text-gray-600">Tipo</th>
                    <th class="px-5 py-3.5 text-right text-[10px] font-semibold uppercase text-gray-600">Cantidad</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Motivo</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Usuario</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movimientos as $m)
                    <tr class="border-b border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 text-sm text-gray-200">{{ $m->inventario?->repuesto?->nombre ?? '—' }}</td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $m->tipo === 'entrada' ? 'bg-green-500/10 text-green-400' : ($m->tipo === 'salida' ? 'bg-red-500/10 text-red-400' : 'bg-yellow-500/10 text-yellow-400') }}">
                                {{ ucfirst($m->tipo) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right text-sm font-medium text-gray-200">{{ $m->cantidad }}</td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $m->motivo ?? '—' }}</td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $m->usuario?->name ?? '—' }}</td>
                        <td class="px-5 py-4 text-xs text-gray-600">{{ $m->created_at ? $m->created_at->format('d/m/Y H:i') : '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-sm text-gray-500">Sin movimientos registrados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

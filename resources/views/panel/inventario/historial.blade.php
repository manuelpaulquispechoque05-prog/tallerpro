@extends('layouts.panel')
@section('title', 'Historial: ' . $repuesto->nombre)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-5 lg:p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-sm font-semibold text-gray-100">Historial de movimientos</h1>
                <p class="text-xs text-gray-500 mt-0.5">{{ $repuesto->nombre }} ({{ $repuesto->codigo }})</p>
            </div>
            <a href="{{ route('panel.inventario.index') }}" class="px-4 py-2 bg-white/5 border border-white/10 text-gray-300 text-xs font-medium rounded-full transition">Volver</a>
        </div>
    </div>

    <div class="animate-in animate-in-d2 glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/[0.04]">
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Tipo</th>
                        <th class="px-5 py-3.5 text-right text-[10px] font-semibold uppercase text-gray-600">Cantidad</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Motivo</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Orden</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Usuario</th>
                        <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movimientos as $m)
                    <tr class="border-b border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $m->tipo === 'entrada' ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }}">
                                {{ ucfirst($m->tipo) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right text-sm font-medium text-gray-200">{{ $m->cantidad }}</td>
                        <td class="px-5 py-4"><span class="text-sm text-gray-200">{{ $m->inventario?->repuesto?->nombre ?? '—' }}</span><br><span class="text-xs text-gray-600">{{ $m->inventario?->repuesto?->codigo ?? '' }}</span></td>
                        <td class="px-5 py-4 text-sm text-gray-400">{{ $m->inventario?->sucursal?->nombre ?? '—' }}</td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $m->ordenTrabajo ? '#' . $m->ordenTrabajo->id : '—' }}</td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $m->usuario?->name ?? '—' }}</td>
                        <td class="px-5 py-4 text-xs text-gray-600">{{ $m->created_at ? $m->created_at->format('d/m/Y H:i') : '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-sm text-gray-500">Sin movimientos registrados</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

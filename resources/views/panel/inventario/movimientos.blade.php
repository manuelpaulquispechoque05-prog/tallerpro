@extends('layouts.panel')
@section('title', 'Movimientos de inventario')

@section('content')
<div class="mb-6">
    <h3 class="text-sm font-semibold text-gray-100">Movimientos de inventario</h3>
    <p class="text-xs text-gray-500 mt-0.5">Trazabilidad completa de entradas, salidas y ajustes</p>
</div>

<!-- Filtros por fecha -->
<div class="glass-card rounded-2xl p-5 lg:p-6 mb-6">
    <form method="GET" action="{{ route('panel.inventario.movimientos') }}" class="flex flex-wrap items-end gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1">Desde</label>
            <input type="date" name="desde" value="{{ request('desde') }}" class="px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1">Hasta</label>
            <input type="date" name="hasta" value="{{ request('hasta') }}" class="px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1">Mes</label>
            <select name="mes" class="px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white">
                <option value="" class="bg-[#1a1a1a]">Todos</option>
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" class="bg-[#1a1a1a]" {{ request('mes') == $m ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1">Anio</label>
            <select name="anio" class="px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white">
                <option value="" class="bg-[#1a1a1a]">Todos</option>
                @foreach(range(now()->year, now()->year - 5, -1) as $y)
                    <option value="{{ $y }}" class="bg-[#1a1a1a]" {{ request('anio') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-semibold rounded-xl transition cursor-pointer">Filtrar</button>
            <a href="{{ route('panel.inventario.movimientos') }}" class="px-4 py-2 bg-white/5 border border-white/10 text-gray-300 text-xs font-medium rounded-xl transition">Limpiar</a>
        </div>
    </form>
</div>

<div class="glass-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/[0.04]">
                    <th class="px-4 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Repuesto</th>
                    <th class="px-4 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Codigo</th>
                    <th class="px-4 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Categoria</th>
                    <th class="px-4 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Sucursal</th>
                    <th class="px-4 py-3.5 text-center text-[10px] font-semibold uppercase text-gray-600">Tipo</th>
                    <th class="px-4 py-3.5 text-right text-[10px] font-semibold uppercase text-gray-600">Cantidad</th>
                    <th class="px-4 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Motivo / Origen</th>
                    <th class="px-4 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Responsable</th>
                    <th class="px-4 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movimientos as $m)
                @php
                    $tipoStyles = [
                        'entrada' => ['bg' => 'bg-green-500/10', 'text' => 'text-green-400', 'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6'],
                        'salida' => ['bg' => 'bg-red-500/10', 'text' => 'text-red-400', 'icon' => 'M20 12H4'],
                        'ajuste' => ['bg' => 'bg-amber-500/10', 'text' => 'text-amber-400', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ];
                    $ts = $tipoStyles[$m->tipo] ?? $tipoStyles['ajuste'];
                    $repuesto = $m->inventario?->repuesto;
                @endphp
                <tr class="border-b border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <span class="text-sm text-gray-200 font-medium">{{ $repuesto?->nombre ?? '—' }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 font-mono text-xs text-gray-500">{{ $repuesto?->codigo ?? '—' }}</td>
                    <td class="px-4 py-3.5 text-xs text-gray-500">{{ $repuesto?->categoria?->nombre ?? '—' }}</td>
                    <td class="px-4 py-3.5 text-xs text-gray-500">{{ $m->inventario?->sucursal?->nombre ?? '—' }}</td>
                    <td class="px-4 py-3.5 text-center">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $ts['bg'] }} {{ $ts['text'] }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $ts['icon'] }}"/></svg>
                            {{ ucfirst($m->tipo) }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5 text-right text-sm font-medium text-gray-200">{{ $m->cantidad }}</td>
                    <td class="px-4 py-3.5 text-xs">
                        @if($m->ordenTrabajo)
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <span class="text-blue-400">Consumo en orden #{{ $m->ordenTrabajo->id }}</span>
                            </div>
                            <span class="text-gray-600 block mt-0.5">{{ Str::limit($m->motivo ?? '', 40) }}</span>
                        @elseif($m->tipo === 'entrada' && $m->motivo)
                            <span class="text-gray-500">Ingreso: {{ Str::limit($m->motivo, 50) }}</span>
                        @else
                            <span class="text-gray-500">{{ Str::limit($m->motivo ?? '—', 50) }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3.5 text-xs text-gray-500">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $m->usuario?->name ?? 'Sistema' }}
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-xs text-gray-600 whitespace-nowrap">
                        <div>{{ $m->created_at?->format('d/m/Y') ?? '—' }}</div>
                        <div class="text-gray-700">{{ $m->created_at?->format('H:i') ?? '' }}</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-12 text-center">
                        <svg class="w-10 h-10 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <p class="text-sm text-gray-500">No hay movimientos registrados</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($movimientos->hasPages())
        <div class="px-5 lg:px-6 py-4 border-t border-white/[0.06]">{{ $movimientos->links() }}</div>
    @endif
</div>
@endsection

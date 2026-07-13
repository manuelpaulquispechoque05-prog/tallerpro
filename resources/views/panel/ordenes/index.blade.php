@extends('layouts.panel')
@section('title', 'Ordenes de trabajo')

@section('content')
<div class="glass-card rounded-2xl overflow-hidden">
    <div class="px-5 lg:px-6 py-4 border-b border-white/[0.06] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h3 class="text-sm font-semibold text-gray-100">Ordenes de trabajo</h3>
            <p class="text-xs text-gray-500 mt-0.5">Gestion de ordenes del taller</p>
        </div>
    </div>

    <div class="px-5 lg:px-6 py-3 border-b border-white/[0.06]">
        <form method="GET" action="{{ route('panel.ordenes.index') }}" class="flex flex-col sm:flex-row gap-3" x-data>
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar por cliente o placa..."
                       class="w-full pl-10 pr-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                       x-on:input.debounce.500ms="$el.form.submit()">
            </div>
            <select name="estado" onchange="this.form.submit()" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white">
                <option value="" class="bg-[#1a1a1a]">Todos los estados</option>
                @foreach(['pendiente', 'en_proceso', 'completado', 'cancelado'] as $est)
                    <option value="{{ $est }}" class="bg-[#1a1a1a]" {{ $estadoFiltro === $est ? 'selected' : '' }}>{{ ucfirst($est) }}</option>
                @endforeach
            </select>
        </form>
    </div>

    @if (session('success'))
        <div class="mx-5 lg:mx-6 mt-4 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/[0.04]">
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">#</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Cliente</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Vehiculo</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Mecanico</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Estado</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Total</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Fecha</th>
                    <th class="px-5 py-3.5 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-600">Accion</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $colorEstado = [
                        'pendiente' => ['dot' => 'bg-yellow-400', 'bg' => 'bg-yellow-500/10', 'text' => 'text-yellow-400'],
                        'en_proceso' => ['dot' => 'bg-blue-400', 'bg' => 'bg-blue-500/10', 'text' => 'text-blue-400'],
                        'completado' => ['dot' => 'bg-green-400', 'bg' => 'bg-green-500/10', 'text' => 'text-green-400'],
                        'cancelado' => ['dot' => 'bg-gray-400', 'bg' => 'bg-gray-500/10', 'text' => 'text-gray-400'],
                    ];
                @endphp
                @forelse($ordenes as $o)
                    @php $e = $colorEstado[$o->estado] ?? $colorEstado['pendiente']; @endphp
                    <tr class="border-b border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 font-medium text-gray-300">#{{ $o->id }}</td>
                        <td class="px-5 py-4 text-sm text-gray-200">{{ $o->cliente?->nombre_completo ?? '—' }}</td>
                        <td class="px-5 py-4 text-sm text-gray-400 font-mono">{{ $o->vehiculo?->placa ?? '—' }}</td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $o->mecanico?->nombre_completo ?? '—' }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $e['bg'] }} {{ $e['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $e['dot'] }}"></span>
                                {{ ucfirst($o->estado) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 font-medium text-gray-200">${{ number_format($o->total, 0) }}</td>
                        <td class="px-5 py-4 text-xs text-gray-500">{{ $o->fecha_ingreso?->format('d/m/Y') ?? '—' }}</td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('panel.ordenes.show', $o->id) }}" class="p-2 rounded-lg hover:bg-white/10 transition text-gray-400 hover:text-blue-400 inline-block" title="Ver">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-10 text-center text-sm text-gray-500">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <p>No hay ordenes de trabajo registradas</p>
                            <p class="text-xs text-gray-600 mt-1">Las ordenes se crean automaticamente desde una cita asignada.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($ordenes->hasPages())
        <div class="px-5 lg:px-6 py-4 border-t border-white/[0.06]">{{ $ordenes->links() }}</div>
    @endif
</div>
@endsection

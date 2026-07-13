@extends('layouts.panel')
@section('title', 'Citas')

@section('content')
<div class="glass-card rounded-2xl overflow-hidden">
    <div class="px-5 lg:px-6 py-4 border-b border-white/[0.06] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h3 class="text-sm font-semibold text-gray-100">Citas</h3>
            <p class="text-xs text-gray-500 mt-0.5">Gestion de citas del taller</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="px-5 lg:px-6 py-3 border-b border-white/[0.06] flex flex-col sm:flex-row gap-3">
        <form method="GET" action="{{ route('panel.citas.index') }}" class="flex flex-col sm:flex-row gap-3 w-full" x-data>
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar por cliente..."
                       class="w-full pl-10 pr-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition"
                       x-on:input.debounce.500ms="$el.form.submit()">
            </div>
            <select name="estado" onchange="this.form.submit()" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                <option value="" class="bg-[#1a1a1a]">Todos los estados</option>
                @foreach(['pendiente', 'confirmada', 'asignada', 'atendida', 'cancelada'] as $est)
                    <option value="{{ $est }}" class="bg-[#1a1a1a]" {{ $estadoFiltro === $est ? 'selected' : '' }}>{{ ucfirst($est) }}</option>
                @endforeach
            </select>
        </form>
    </div>

    @if (session('success'))
        <div class="mx-5 lg:mx-6 mt-4 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mx-5 lg:mx-6 mt-4 p-3 bg-red-500/10 border border-red-500/20 rounded-xl text-sm text-red-400">{{ session('error') }}</div>
    @endif
    @if (session('info'))
        <div class="mx-5 lg:mx-6 mt-4 p-3 bg-blue-500/10 border border-blue-500/20 rounded-xl text-sm text-blue-400">{{ session('info') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/[0.04]">
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">#</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Cliente</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Servicio</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Vehiculo</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Fecha / Hora</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Mecanico</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Estado</th>
                    <th class="px-5 py-3.5 text-right text-[10px] font-semibold uppercase tracking-wider text-gray-600">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $colorEstado = [
                        'pendiente' => ['dot' => 'bg-yellow-400', 'bg' => 'bg-yellow-500/10', 'text' => 'text-yellow-400'],
                        'confirmada' => ['dot' => 'bg-blue-400', 'bg' => 'bg-blue-500/10', 'text' => 'text-blue-400'],
                        'asignada' => ['dot' => 'bg-purple-400', 'bg' => 'bg-purple-500/10', 'text' => 'text-purple-400'],
                        'atendida' => ['dot' => 'bg-green-400', 'bg' => 'bg-green-500/10', 'text' => 'text-green-400'],
                        'cancelada' => ['dot' => 'bg-gray-400', 'bg' => 'bg-gray-500/10', 'text' => 'text-gray-400'],
                    ];
                @endphp
                @forelse($citas as $c)
                    @php $e = $colorEstado[$c->estado] ?? $colorEstado['pendiente']; @endphp
                    <tr class="border-b border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 font-medium text-gray-300">#{{ $c->id }}</td>
                        <td class="px-5 py-4">
                            <p class="text-sm text-gray-200">{{ $c->cliente?->nombre_completo ?? '—' }}</p>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-400">{{ $c->servicio?->nombre ?? 'Diagnostico' }}</td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $c->tipoVehiculo?->nombre ?? '—' }}</td>
                        <td class="px-5 py-4 text-sm text-gray-400">{{ $c->fecha_hora?->format('d/m/Y H:i') ?? '—' }}</td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $c->mecanico?->nombre_completo ?? '—' }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $e['bg'] }} {{ $e['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $e['dot'] }}"></span>
                                {{ ucfirst($c->estado) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('panel.citas.show', $c->id) }}" class="p-2 rounded-lg hover:bg-white/10 transition text-gray-400 hover:text-blue-400" title="Ver detalle">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @if($c->estado === 'pendiente')
                                    <a href="{{ route('panel.citas.confirmar', $c->id) }}" class="p-2 rounded-lg hover:bg-white/10 transition text-gray-400 hover:text-green-400" title="Confirmar" onclick="return confirm('Confirmar esta cita?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-5 py-10 text-center text-sm text-gray-500">No hay citas registradas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($citas->hasPages())
        <div class="px-5 lg:px-6 py-4 border-t border-white/[0.06]">{{ $citas->links() }}</div>
    @endif
</div>
@endsection

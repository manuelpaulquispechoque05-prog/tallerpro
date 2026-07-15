@extends('layouts.panel')
@section('title', 'Vehiculos')

@section('content')
<div class="glass-card rounded-2xl overflow-hidden shadow-xl shadow-black/20">
    <div class="px-5 lg:px-6 py-5 border-b border-white/[0.06] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                Directorio de Vehiculos
            </h3>
            <p class="text-xs text-gray-400 mt-1">Gestiona todos los vehiculos registrados en el sistema.</p>
        </div>
        <a href="{{ route('panel.vehiculos.create') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(59,130,246,0.4)] hover:shadow-[0_0_25px_rgba(59,130,246,0.6)] hover:-translate-y-0.5">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Registrar Vehiculo
        </a>
    </div>

    <div class="px-5 lg:px-6 py-4 border-b border-white/[0.06] bg-white/[0.01]">
        <form method="GET" action="{{ route('panel.vehiculos.index') }}" x-data>
            <div class="relative max-w-md">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar por placa, VIN o cliente..."
                       class="w-full pl-10 pr-4 py-2.5 bg-white/[0.03] border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all shadow-inner"
                       x-on:input.debounce.500ms="$el.form.submit()">
            </div>
        </form>
    </div>

    @if (session('success'))
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
                    <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">ID</th>
                    <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Placa</th>
                    <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Propietario</th>
                    <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Vehiculo</th>
                    <th class="px-5 py-4 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">Estado</th>
                    <th class="px-5 py-4 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/[0.02]">
                @forelse($vehiculos as $v)
                    <tr class="hover:bg-white/[0.03] transition-colors group">
                        <td class="px-5 py-4 font-mono text-xs text-gray-500 group-hover:text-gray-400 transition-colors">#{{ $v->id }}</td>
                        <td class="px-5 py-4">
                            <div class="inline-flex flex-col items-center justify-center bg-[#f2e6d9] text-gray-900 border-2 border-gray-400 rounded px-2.5 py-0.5 shadow-sm transform group-hover:scale-105 transition-transform">
                                <span class="text-[8px] font-bold tracking-widest text-gray-500 uppercase leading-none mb-0.5 border-b border-gray-400/30 w-full text-center pb-[1px]">BOLIVIA</span>
                                <span class="font-mono text-sm font-bold tracking-widest">{{ $v->placa }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-indigo-500/30 flex items-center justify-center text-xs font-bold text-indigo-300 shadow-inner">
                                    {{ $v->cliente ? substr($v->cliente->nombre_completo, 0, 1) : '?' }}
                                </div>
                                <span class="text-sm font-medium text-gray-200">{{ $v->cliente?->nombre_completo ?? 'Sin asignar' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-200">{{ $v->marca?->nombre ?? 'N/A' }} <span class="text-gray-400 font-normal">{{ $v->modelo?->nombre ?? 'N/A' }}</span></span>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-white/5 text-gray-400 border border-white/10">{{ $v->anio }}</span>
                                    @if($v->color)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-white/5 text-gray-400 border border-white/10 capitalize">{{ $v->color }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($v->activo)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-[0_0_10px_rgba(16,185,129,0.1)]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Activo
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-500/10 text-gray-400 border border-gray-500/20">
                                    Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('panel.vehiculos.show', $v->id) }}" class="p-2 rounded-lg bg-white/5 hover:bg-blue-500/20 hover:text-blue-400 border border-transparent hover:border-blue-500/30 text-gray-400 transition-all" title="Ver detalle">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('panel.vehiculos.edit', $v->id) }}" class="p-2 rounded-lg bg-white/5 hover:bg-yellow-500/20 hover:text-yellow-400 border border-transparent hover:border-yellow-500/30 text-gray-400 transition-all" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('panel.vehiculos.destroy', $v->id) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este vehículo?')" class="inline">
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
                        <td colspan="6" class="px-5 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 mb-4 border border-white/10">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <p class="text-sm font-medium text-gray-400">No hay vehiculos registrados</p>
                            <p class="text-xs text-gray-500 mt-1 mb-4">Comienza registrando el primer vehiculo del taller.</p>
                            <a href="{{ route('panel.vehiculos.create') }}" class="inline-flex items-center px-4 py-2 border border-blue-500/50 text-blue-400 text-xs font-semibold rounded-full hover:bg-blue-500/10 transition-colors">
                                Registrar ahora
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($vehiculos->hasPages())
        <div class="px-5 lg:px-6 py-4 border-t border-white/[0.06] bg-white/[0.01]">
            {{ $vehiculos->links() }}
        </div>
    @endif
</div>
@endsection

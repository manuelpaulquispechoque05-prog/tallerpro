@extends('layouts.panel')
@section('title', 'Clientes')

@section('content')
<!-- Stats bar -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    <div class="glass-card rounded-2xl p-4 text-center">
        <p class="text-2xl font-bold text-white">{{ $clientes->total() }}</p>
        <p class="text-xs text-gray-500 mt-1">Total clientes</p>
    </div>
    <div class="glass-card rounded-2xl p-4 text-center">
        <p class="text-2xl font-bold text-green-400">{{ $clientes->total() }}</p>
        <p class="text-xs text-gray-500 mt-1">Registrados</p>
    </div>
    <div class="glass-card rounded-2xl p-4 text-center">
        <p class="text-2xl font-bold text-gray-400">—</p>
        <p class="text-xs text-gray-500 mt-1">Con vehiculos</p>
    </div>
    <div class="glass-card rounded-2xl p-4 text-center">
        <p class="text-2xl font-bold text-blue-400">{{ $clientes->total() }}</p>
        <p class="text-xs text-gray-500 mt-1">En el sistema</p>
    </div>
</div>

<!-- Search + New -->
<div class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="flex-1">
        <form method="GET" x-data>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar por nombre, CI o telefono..." class="w-full pl-10 pr-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" x-on:input.debounce.500ms="$el.form.submit()">
            </div>
        </form>
    </div>
    <a href="{{ route('panel.clientes.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-blue-500/25 shrink-0">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nuevo cliente
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400">{{ session('success') }}</div>
@endif

<!-- Client Cards Grid -->
@if($clientes->count() > 0)
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($clientes as $c)
    <div class="glass-card rounded-2xl p-5 hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-300 group">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-blue-500/20">
                    {{ substr($c->nombre, 0, 1) }}{{ substr($c->apellido, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-100">{{ $c->nombre_completo }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">#{{ $c->id }} • {{ $c->ci_nit }}</p>
                </div>
            </div>
            <span class="w-2.5 h-2.5 rounded-full {{ $c->activo ? 'bg-green-400' : 'bg-gray-500' }}"></span>
        </div>
        <div class="space-y-1.5 text-xs text-gray-400">
            <div class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>{{ $c->telefono }}</div>
            <div class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>{{ $c->email ?? 'Sin correo' }}</div>
            <div class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Desde {{ $c->created_at->format('d/m/Y') }}</div>
        </div>
        <div class="mt-4 pt-3 border-t border-white/[0.06] flex items-center justify-between">
            <a href="{{ route('panel.clientes.show', $c->id) }}" class="text-xs font-medium text-blue-400 hover:text-blue-300 transition flex items-center gap-1">
                Ver perfil <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <div class="flex gap-1">
                <a href="{{ route('panel.clientes.edit', $c->id) }}" class="p-1.5 rounded-lg hover:bg-white/10 transition text-gray-500 hover:text-yellow-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                <form method="POST" action="{{ route('panel.clientes.destroy', $c->id) }}" onsubmit="return confirm('Eliminar cliente?')" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-1.5 rounded-lg hover:bg-white/10 transition text-gray-500 hover:text-red-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="glass-card rounded-2xl p-10 text-center">
    <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
    <p class="text-sm text-gray-500">No hay clientes registrados</p>
    <a href="{{ route('panel.clientes.create') }}" class="text-blue-400 hover:text-blue-300 transition mt-2 inline-block text-sm">Registrar primer cliente</a>
</div>
@endif

@if($clientes->hasPages())
    <div class="mt-6">{{ $clientes->links() }}</div>
@endif
@endsection

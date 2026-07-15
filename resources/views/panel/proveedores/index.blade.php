@extends('layouts.panel')
@section('title', 'Proveedores')
@section('content')
<div class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="flex-1"><form method="GET" x-data><div class="relative"><svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg><input type="text" name="busqueda" value="{{ request('busqueda') }}" placeholder="Buscar proveedor..." class="w-full pl-10 pr-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" x-on:input.debounce.500ms="$el.form.submit()"></div></form></div>
    <a href="{{ route('panel.proveedores.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-blue-500/25 shrink-0">Nuevo proveedor</a>
</div>
@if(session('success'))<div class="mb-6 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400">{{ session('success') }}</div>@endif
@if($items->count() > 0)
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($items as $i)
    <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all duration-300">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center text-blue-400 font-bold text-lg">{{ substr($i->nombre, 0, 1) }}</div>
            <div><p class="text-sm font-semibold text-gray-100">{{ $i->nombre }}</p><p class="text-xs text-gray-500">{{ $i->nit ?? '—' }}</p></div>
        </div>
        <div class="space-y-1.5 text-xs text-gray-400">
            <div class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>{{ $i->contacto ?? '—' }}</div>
            <div class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>{{ $i->telefono ?? '—' }}</div>
            <div class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>{{ $i->email ?? '—' }}</div>
        </div>
        <div class="mt-3 pt-3 border-t border-white/[0.06] flex items-center justify-between">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $i->activo ? 'bg-green-500/10 text-green-400' : 'bg-gray-500/10 text-gray-400' }}">{{ $i->activo ? 'Activo' : 'Inactivo' }}</span>
            <div class="flex gap-1">
                <a href="{{ route('panel.proveedores.edit', $i->id) }}" class="p-1.5 rounded-lg hover:bg-white/10 transition text-gray-500 hover:text-yellow-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                <form method="POST" action="{{ route('panel.proveedores.destroy', $i->id) }}" onsubmit="return confirm('Eliminar?')" class="inline">@csrf @method('DELETE')<button type="submit" class="p-1.5 rounded-lg hover:bg-white/10 transition text-gray-500 hover:text-red-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="glass-card rounded-2xl p-10 text-center"><p class="text-sm text-gray-500">No hay proveedores registrados</p></div>
@endif
@if($items->hasPages())<div class="mt-6">{{ $items->links() }}</div>@endif
@endsection

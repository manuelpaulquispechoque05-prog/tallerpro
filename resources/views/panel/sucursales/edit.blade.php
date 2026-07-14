@extends('layouts.panel')
@section('title', 'Editar sucursal')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <h1 class="text-sm font-semibold text-gray-100 mb-6">Editar: {{ $item->nombre }}</h1>
        <form method="POST" action="{{ route('panel.sucursales.update', $item->id) }}">@csrf @method('PUT')
            <div class="grid sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-300 mb-1.5">Nombre *</label><input name="nombre" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" value="{{ $item->nombre }}" required>@error('nombre')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-300 mb-1.5">Direccion *</label><input name="direccion" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" value="{{ $item->direccion }}" required></div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Ciudad *</label><input name="ciudad" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" value="{{ $item->ciudad }}" required></div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Telefono</label><input name="telefono" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" value="{{ $item->telefono }}"></div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Activo</label>
                    <select name="activo" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white">
                        <option value="1" class="bg-[#1a1a1a]" {{ $item->activo ? 'selected' : '' }}>Activo</option>
                        <option value="0" class="bg-[#1a1a1a]" {{ !$item->activo ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-3 pt-4 mt-5 border-t border-white/[0.06]">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">Guardar</button>
                <a href="{{ route('panel.sucursales.index') }}" class="px-6 py-2.5 bg-white/5 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

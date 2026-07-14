@extends('layouts.panel')
@section('title', 'Nueva sucursal')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <h1 class="text-sm font-semibold text-gray-100 mb-6">Nueva sucursal</h1>
        <form method="POST" action="{{ route('panel.sucursales.store') }}">@csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-300 mb-1.5">Nombre *</label><input name="nombre" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" required placeholder="Ej: Sucursal Centro">@error('nombre')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-300 mb-1.5">Direccion *</label><input name="direccion" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" required placeholder="Av. Principal #123">@error('direccion')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Ciudad *</label><input name="ciudad" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" required placeholder="Santa Cruz" value="Santa Cruz de la Sierra">@error('ciudad')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Telefono</label><input name="telefono" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" placeholder="70000000"></div>
            </div>
            <div class="flex gap-3 pt-4 mt-5 border-t border-white/[0.06]">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">Crear sucursal</button>
                <a href="{{ route('panel.sucursales.index') }}" class="px-6 py-2.5 bg-white/5 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

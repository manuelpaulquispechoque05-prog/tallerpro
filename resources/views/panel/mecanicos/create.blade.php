@extends('layouts.panel')
@section('title', 'Nuevo mecanico')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <h1 class="text-sm font-semibold text-gray-100 mb-6">Nuevo mecanico</h1>
        <form method="POST" action="{{ route('panel.mecanicos.store') }}">
            @csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Nombre *</label><input name="nombre" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" required placeholder="Ej: Juan">@error('nombre')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Apellidos *</label><input name="apellidos" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" required placeholder="Ej: Perez Lopez">@error('apellidos')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">CI</label><input name="ci" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" placeholder="Ej: 1234567">@error('ci')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Telefono</label><input name="telefono" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" placeholder="Ej: 70000000"></div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-300 mb-1.5">Direccion</label><input name="direccion" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" placeholder="Opcional"></div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Especialidad *</label>
                    <select name="especialidad_id" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white">
                        <option value="" class="bg-[#1a1a1a]">Seleccionar</option>
                        @foreach($especialidades as $e)<option value="{{ $e->id }}" class="bg-[#1a1a1a]">{{ $e->nombre }}</option>@endforeach
                    </select>
                    @error('especialidad_id')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Sucursal *</label>
                    <select name="sucursal_id" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white">
                        @foreach($sucursales as $s)<option value="{{ $s->id }}" class="bg-[#1a1a1a]" {{ $loop->first ? 'selected' : '' }}>{{ $s->nombre }}</option>@endforeach
                    </select>
                    @error('sucursal_id')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Fecha contratacion *</label><input name="fecha_contratacion" type="date" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" required></div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-300 mb-1.5">Perfil / observaciones</label><textarea name="descripcion" rows="2" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" placeholder="Opcional"></textarea></div>
            </div>
            <div class="flex gap-3 pt-4 mt-5 border-t border-white/[0.06]">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">Registrar mecanico</button>
                <a href="{{ route('panel.mecanicos.index') }}" class="px-6 py-2.5 bg-white/5 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

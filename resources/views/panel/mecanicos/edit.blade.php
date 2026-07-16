@extends('layouts.panel')
@section('title', 'Editar mecanico')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <h1 class="text-sm font-semibold text-gray-100 mb-6">Editar: {{ $item->nombre_completo }}</h1>
        <form method="POST" action="{{ route('panel.mecanicos.update', $item->id) }}">@csrf @method('PUT')
            <div class="grid sm:grid-cols-2 gap-5">
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Nombre *</label><input name="nombre" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" value="{{ $item->nombre }}" required></div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Apellidos *</label><input name="apellidos" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" value="{{ $item->apellidos }}" required></div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">CI</label><input name="ci" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" value="{{ $item->ci }}"></div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Telefono</label><input name="telefono" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" value="{{ $item->telefono }}"></div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-300 mb-1.5">Direccion</label><input name="direccion" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" value="{{ $item->direccion }}"></div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Especialidad *</label>
                    <select name="especialidad_id" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white">
                        @foreach($especialidades as $e)<option value="{{ $e->id }}" class="bg-[#1a1a1a]" {{ $item->especialidad_id == $e->id ? 'selected' : '' }}>{{ $e->nombre }}</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Sucursal *</label>
                    <select name="sucursal_id" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white">
                        @foreach($sucursales as $s)<option value="{{ $s->id }}" class="bg-[#1a1a1a]" {{ $item->sucursal_id == $s->id ? 'selected' : '' }}>{{ $s->nombre }}</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Activo</label>
                    <select name="activo" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white">
                        <option value="1" class="bg-[#1a1a1a]" {{ $item->activo ? 'selected' : '' }}>Activo</option>
                        <option value="0" class="bg-[#1a1a1a]" {{ !$item->activo ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Fecha contratacion</label><input name="fecha_contratacion" type="date" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white" value="{{ $item->fecha_contratacion?->format('Y-m-d') }}" required></div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-300 mb-1.5">Descripcion</label><textarea name="descripcion" rows="2" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white">{{ $item->descripcion }}</textarea></div>
            </div>
            <div class="flex gap-3 pt-4 mt-5 border-t border-white/[0.06]">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">Guardar</button>
                <a href="{{ route('panel.mecanicos.index') }}" class="px-6 py-2.5 bg-white/5 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

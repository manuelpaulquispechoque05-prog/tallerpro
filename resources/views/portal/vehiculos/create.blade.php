@extends('layouts.portal')
@section('title', 'Registrar vehiculo')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-white">Registrar vehiculo</h1>
        <p class="text-sm text-gray-400 mt-1">Completa los datos de tu vehiculo</p>
    </div>

    <div class="glass-card rounded-2xl p-6 lg:p-8">
        <form method="POST" action="{{ route('portal.vehiculos.store') }}">
            @csrf

            <div x-data="{
                marcaId: {{ old('marca_id', 'null') }},
                modelos: [],
                cargando: false,
                cargarModelos() {
                    if (!this.marcaId) { this.modelos = []; return; }
                    this.cargando = true;
                    fetch('/portal/vehiculos/modelos-por-marca/' + this.marcaId)
                        .then(r => r.json())
                        .then(data => { this.modelos = data; this.cargando = false; });
                }
            }" x-init="if (marcaId) cargarModelos()">

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Marca *</label>
                        <select name="marca_id" x-model="marcaId" @change="cargarModelos()" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                            <option value="" class="bg-[#1a1a1a]">Seleccionar</option>
                            @foreach($marcas as $m)
                                <option value="{{ $m->id }}" class="bg-[#1a1a1a]">{{ $m->nombre }}</option>
                            @endforeach
                        </select>
                        @error('marca_id')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Modelo *</label>
                        <select name="modelo_id" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                            <option value="" class="bg-[#1a1a1a]">Seleccionar modelo</option>
                            <template x-for="m in modelos" :key="m.id">
                                <option :value="m.id" class="bg-[#1a1a1a]" x-text="m.nombre"></option>
                            </template>
                        </select>
                        <p x-show="cargando" class="mt-1 text-xs text-gray-500">Cargando modelos...</p>
                        @error('modelo_id')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Anio *</label>
                        <select name="anio" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                            <option value="" class="bg-[#1a1a1a]">Seleccionar</option>
                            @for ($y = now()->year; $y >= 1990; $y--)
                                <option value="{{ $y }}" class="bg-[#1a1a1a]">{{ $y }}</option>
                            @endfor
                        </select>
                        @error('anio')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Placa *</label>
                        <input name="placa" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('placa') }}" required placeholder="Ej: ABC-123">
                        @error('placa')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-5 mt-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Color</label>
                        <input name="color" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('color') }}" placeholder="Ej: Rojo">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">VIN</label>
                        <input name="vin" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('vin') }}" placeholder="17 caracteres">
                        @error('vin')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Kilometraje</label>
                        <input name="kilometraje" type="number" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('kilometraje', 0) }}" placeholder="0">
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-5 border-t border-white/[0.06]">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">Registrar vehiculo</button>
                <a href="{{ route('portal.vehiculos.index') }}" class="px-6 py-2.5 bg-white/5 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.panel')
@section('title', 'Nueva especialidad')
@section('content')
<div class="max-w-lg mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <h1 class="text-sm font-semibold text-gray-100 mb-6">Nueva especialidad</h1>
        <form method="POST" action="{{ route('panel.especialidades.store') }}">
            @csrf
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Nombre *</label>
            <input name="nombre" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" required placeholder="Ej: Motor">
            @error('nombre')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
            <div class="flex gap-3 pt-4 mt-5 border-t border-white/[0.06]">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">Crear</button>
                <a href="{{ route('panel.especialidades.index') }}" class="px-6 py-2.5 bg-white/5 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

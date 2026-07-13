@props(['item' => null])
<div>
    <label class="block text-sm font-medium text-gray-300 mb-1.5">Nombre *</label>
    <input name="nombre" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('nombre', $item?->nombre) }}" required placeholder="Ej: Filtros">
    @error('nombre')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
</div>
<div class="mt-5">
    <label class="block text-sm font-medium text-gray-300 mb-1.5">Descripcion</label>
    <textarea name="descripcion" rows="2" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" placeholder="Opcional">{{ old('descripcion', $item?->descripcion) }}</textarea>
</div>
<div class="flex items-center gap-3 pt-4 mt-5 border-t border-white/[0.06]">
    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">{{ $item ? 'Guardar' : 'Crear categoria' }}</button>
    <a href="{{ route('panel.categorias.index') }}" class="px-6 py-2.5 bg-white/5 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
</div>

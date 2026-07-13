@props(['item' => null])
<div class="grid sm:grid-cols-2 gap-5">
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Nombre de la empresa *</label>
        <input name="nombre" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('nombre', $item?->nombre) }}" required placeholder="Ej: Repuestos Santa Cruz SRL">
        @error('nombre')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">NIT</label>
        <input name="nit" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('nit', $item?->nit) }}" placeholder="Opcional">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Nombre del contacto</label>
        <input name="contacto" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('contacto', $item?->contacto) }}" placeholder="Ej: Juan Perez">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Telefono</label>
        <input name="telefono" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('telefono', $item?->telefono) }}" placeholder="Ej: 70000000">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Correo</label>
        <input name="email" type="email" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('email', $item?->email) }}" placeholder="correo@empresa.com">
    </div>
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Direccion</label>
        <input name="direccion" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('direccion', $item?->direccion) }}" placeholder="Opcional">
    </div>
</div>
<div class="flex items-center gap-3 pt-4 mt-5 border-t border-white/[0.06]">
    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">{{ $item ? 'Guardar cambios' : 'Crear proveedor' }}</button>
    <a href="{{ route('panel.proveedores.index') }}" class="px-6 py-2.5 bg-white/5 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
</div>

@props(['cliente' => null])

<div class="grid sm:grid-cols-2 gap-5">
    <div>
        <label for="nombre" class="block text-sm font-medium text-gray-300 mb-1.5">Nombre *</label>
        <input id="nombre" name="nombre" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" value="{{ old('nombre', $cliente?->nombre) }}" required placeholder="Ej: Juan">
        @error('nombre')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="apellido" class="block text-sm font-medium text-gray-300 mb-1.5">Apellidos *</label>
        <input id="apellido" name="apellido" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" value="{{ old('apellido', $cliente?->apellido) }}" required placeholder="Ej: Perez Lopez">
        @error('apellido')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="ci_nit" class="block text-sm font-medium text-gray-300 mb-1.5">CI / NIT *</label>
        <input id="ci_nit" name="ci_nit" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" value="{{ old('ci_nit', $cliente?->ci_nit) }}" required placeholder="Ej: 1234567">
        @error('ci_nit')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="telefono" class="block text-sm font-medium text-gray-300 mb-1.5">Telefono / Celular *</label>
        <input id="telefono" name="telefono" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" value="{{ old('telefono', $cliente?->telefono) }}" required placeholder="Ej: 70000000">
        @error('telefono')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">Correo electronico</label>
        <input id="email" name="email" type="email" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" value="{{ old('email', $cliente?->email) }}" placeholder="Ej: cliente@correo.com">
        @error('email')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="direccion" class="block text-sm font-medium text-gray-300 mb-1.5">Direccion</label>
        <input id="direccion" name="direccion" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" value="{{ old('direccion', $cliente?->direccion) }}" placeholder="Ej: Av. Principal #123">
        @error('direccion')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>
</div>

<div class="flex items-center gap-3 pt-4 mt-2 border-t border-white/[0.06]">
    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-lg shadow-blue-500/25 cursor-pointer">
        {{ $cliente ? 'Guardar cambios' : 'Registrar cliente' }}
    </button>
    <a href="{{ route('panel.clientes.index') }}" class="px-6 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
</div>

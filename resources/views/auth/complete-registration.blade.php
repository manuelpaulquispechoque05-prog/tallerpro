<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-white">Completar registro</h1>
        <p class="mt-2 text-sm text-gray-400">Tus datos de Google fueron verificados. Completa tu informacion para crear tu cuenta.</p>
    </div>

    <form method="POST" action="{{ route('register.complete.store') }}">
        @csrf

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Nombre *</label>
                <input name="nombre" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('nombre') }}" required placeholder="Ej: Juan">
                @error('nombre')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Apellido *</label>
                <input name="apellido" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('apellido') }}" required placeholder="Ej: Perez">
                @error('apellido')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mt-5">
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Correo electronico</label>
            <input type="email" value="{{ $data['email'] }}" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-gray-400 cursor-not-allowed" readonly>
        </div>

        <div class="mt-5 grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">CI / NIT *</label>
                <input name="ci_nit" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('ci_nit') }}" required placeholder="Ej: 1234567">
                @error('ci_nit')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Telefono *</label>
                <input name="telefono" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('telefono') }}" required placeholder="Ej: 70000000">
                @error('telefono')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mt-5">
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Direccion</label>
            <input name="direccion" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('direccion') }}" placeholder="Opcional">
        </div>

        <div class="mt-6 grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Contrasena *</label>
                <input name="password" type="password" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" required placeholder="Min. 8 caracteres">
                @error('password')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Confirmar contrasena</label>
                <input name="password_confirmation" type="password" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" required placeholder="Repite la contrasena">
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-lg shadow-blue-500/25 cursor-pointer">Crear cuenta</button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium transition">Volver a iniciar sesion</a>
    </p>
</x-guest-layout>

<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-white">Confirmar contrasena</h1>
        <p class="mt-2 text-sm text-gray-400">Esta es un area segura. Confirma tu contrasena para continuar.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">Contrasena</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="********" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="mt-6">
            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-lg shadow-blue-500/25 cursor-pointer">Confirmar</button>
        </div>
    </form>
</x-guest-layout>

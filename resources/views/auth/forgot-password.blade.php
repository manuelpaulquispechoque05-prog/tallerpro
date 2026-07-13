<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-white">Recuperar contrasena</h1>
        <p class="mt-2 text-sm text-gray-400">Te enviaremos un enlace para restablecer tu contrasena</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">Correo electronico</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="tu@correo.com" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mt-6">
            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-lg shadow-blue-500/25 cursor-pointer">Enviar enlace de recuperacion</button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium transition inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Volver a iniciar sesion
        </a>
    </p>
</x-guest-layout>

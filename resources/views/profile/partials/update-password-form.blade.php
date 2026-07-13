<section>
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-gray-100">Cambiar contrasena</h2>
        <p class="mt-1 text-sm text-gray-500">Asegurate de usar una contrasena segura y dificil de adivinar.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-300 mb-1.5">Contrasena actual</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" autocomplete="current-password">
            @error('current_password', 'updatePassword')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-300 mb-1.5">Nueva contrasena</label>
            <input id="update_password_password" name="password" type="password" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" autocomplete="new-password">
            @error('password', 'updatePassword')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-300 mb-1.5">Confirmar contrasena</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-lg shadow-blue-500/25 cursor-pointer">Guardar contrasena</button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-400">Guardado.</p>
            @endif
        </div>
    </form>
</section>

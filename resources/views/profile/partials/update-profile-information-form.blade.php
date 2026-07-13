<section>
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-gray-100">Informacion del perfil</h2>
        <p class="mt-1 text-sm text-gray-500">Actualiza el nombre y correo electronico de tu cuenta.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Nombre completo</label>
            <input id="name" name="name" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">Correo electronico</label>
            <input id="email" name="email" type="email" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm text-gray-400">Tu correo no esta verificado.
                        <button form="send-verification" class="text-blue-400 hover:text-blue-300 underline transition">Reenviar verificacion</button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 text-sm text-green-400">Se ha enviado un nuevo enlace de verificacion.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-lg shadow-blue-500/25 cursor-pointer">Guardar cambios</button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-400">Guardado.</p>
            @endif
        </div>
    </form>
</section>

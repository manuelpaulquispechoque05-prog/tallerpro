<section class="space-y-6">
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-gray-100">Eliminar cuenta</h2>
        <p class="mt-1 text-sm text-gray-500">Una vez eliminada tu cuenta, todos tus datos se eliminaran permanentemente.</p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="px-6 py-2.5 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-400 text-sm font-semibold rounded-full transition-all duration-300 cursor-pointer">Eliminar cuenta</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 lg:p-8 bg-[#1a1a1a] rounded-2xl">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-gray-100">Estas seguro?</h2>
            <p class="mt-1 text-sm text-gray-400">Ingresa tu contrasena para confirmar que deseas eliminar tu cuenta permanentemente.</p>

            <div class="mt-6">
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5 sr-only">Contrasena</label>
                <input id="password" name="password" type="password" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" placeholder="Tu contrasena">
                @error('password', 'userDeletion')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition cursor-pointer">Cancelar</button>
                <button type="submit" class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-full transition cursor-pointer">Eliminar cuenta</button>
            </div>
        </form>
    </x-modal>
</section>

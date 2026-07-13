@props(['vehiculo' => null, 'marcas', 'clienteId' => null, 'clienteNombre' => null])

<div x-data="{
    clienteId: {{ old('cliente_id', $vehiculo?->cliente_id ?? ($clienteId ?: 'null')) }},
    clienteTexto: '{{ old('_cliente_texto', $vehiculo?->cliente?->nombre_completo ?? ($clienteNombre ?? '')) }}',
    resultados: [],
    abierto: false,
    cargando: false,

    buscarClientes() {
        if (this.clienteTexto.length < 2) { this.resultados = []; return; }
        this.cargando = true;
        fetch('{{ route('panel.vehiculos.buscar-clientes') }}?q=' + encodeURIComponent(this.clienteTexto))
            .then(r => r.json())
            .then(data => { this.resultados = data; this.abierto = true; this.cargando = false; });
    },

    seleccionarCliente(c) {
        this.clienteId = c.id;
        this.clienteTexto = c.nombre + ' ' + c.apellido + ' (' + c.ci_nit + ')';
        this.abierto = false;
    },

    marcaId: {{ old('marca_id', $vehiculo?->marca_id ?? 'null') }},
    modelos: [],
    cargandoModelos: false,

    cargarModelos() {
        if (!this.marcaId) { this.modelos = []; return; }
        this.cargandoModelos = true;
        fetch('/panel/vehiculos/modelos-por-marca/' + this.marcaId)
            .then(r => r.json())
            .then(data => { this.modelos = data; this.cargandoModelos = false; });
    }
}"
x-init="if (marcaId) cargarModelos()"
class="space-y-5">

    <!-- Cliente -->
    <div class="relative">
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Cliente *</label>
        <input type="hidden" name="cliente_id" x-model="clienteId">
        <input type="text" x-model="clienteTexto" @input.debounce.300ms="buscarClientes()" @focus="if(resultados.length) abierto = true" @click.away="abierto = false"
               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition"
               placeholder="Buscar cliente por nombre o CI...">
        <div x-show="cargando" class="absolute right-3 top-10"><svg class="animate-spin w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg></div>
        <div x-show="abierto && resultados.length" x-transition class="absolute z-20 mt-1 w-full rounded-xl bg-[#1a1a1a] border border-white/10 shadow-2xl max-h-48 overflow-y-auto">
            <template x-for="c in resultados" :key="c.id">
                <button type="button" @click="seleccionarCliente(c)" class="w-full text-left px-4 py-3 text-sm text-gray-300 hover:bg-white/[0.04] transition border-b border-white/[0.03] last:border-0">
                    <span class="font-medium" x-text="c.nombre + ' ' + c.apellido"></span>
                    <span class="text-gray-500 ml-2" x-text="'(' + c.ci_nit + ')'"></span>
                    <span class="text-gray-600 ml-2 text-xs" x-text="c.telefono ? '📞 ' + c.telefono : ''"></span>
                </button>
            </template>
        </div>
        @error('cliente_id')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <!-- Marca -->
    <div>
        <label for="marca_id" class="block text-sm font-medium text-gray-300 mb-1.5">Marca *</label>
        <select id="marca_id" name="marca_id" x-model="marcaId" @change="cargarModelos()" required
                class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition">
            <option value="" class="bg-[#1a1a1a]">Seleccionar marca</option>
            @foreach($marcas as $m)
                <option value="{{ $m->id }}" class="bg-[#1a1a1a]">{{ $m->nombre }}</option>
            @endforeach
        </select>
        @error('marca_id')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <!-- Modelo -->
    <div>
        <label for="modelo_id" class="block text-sm font-medium text-gray-300 mb-1.5">Modelo *</label>
        <select id="modelo_id" name="modelo_id" required
                class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition">
            <option value="" class="bg-[#1a1a1a]">Seleccionar modelo</option>
            <template x-for="m in modelos" :key="m.id">
                <option :value="m.id" :selected="m.id === {{ old('modelo_id', $vehiculo?->modelo_id ?? 'null') }}" class="bg-[#1a1a1a]" x-text="m.nombre"></option>
            </template>
        </select>
        <p x-show="cargandoModelos" class="mt-1 text-xs text-gray-500">Cargando modelos...</p>
        @error('modelo_id')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <!-- Anio + Placa -->
    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <label for="anio" class="block text-sm font-medium text-gray-300 mb-1.5">Anio *</label>
            <select id="anio" name="anio" required
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition">
                <option value="" class="bg-[#1a1a1a]">Seleccionar</option>
                @for ($y = now()->year; $y >= 1990; $y--)
                    <option value="{{ $y }}" class="bg-[#1a1a1a]" {{ old('anio', $vehiculo?->anio) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            @error('anio')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="placa" class="block text-sm font-medium text-gray-300 mb-1.5">Placa *</label>
            <input id="placa" name="placa" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" value="{{ old('placa', $vehiculo?->placa) }}" required placeholder="Ej: ABC-123">
            @error('placa')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>
    </div>

    <!-- VIN + Color + Kilometraje -->
    <div class="grid sm:grid-cols-3 gap-5">
        <div>
            <label for="vin" class="block text-sm font-medium text-gray-300 mb-1.5">VIN</label>
            <input id="vin" name="vin" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" value="{{ old('vin', $vehiculo?->vin) }}" placeholder="17 caracteres">
            @error('vin')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="color" class="block text-sm font-medium text-gray-300 mb-1.5">Color</label>
            <input id="color" name="color" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" value="{{ old('color', $vehiculo?->color) }}" placeholder="Ej: Rojo">
            @error('color')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="kilometraje" class="block text-sm font-medium text-gray-300 mb-1.5">Kilometraje</label>
            <input id="kilometraje" name="kilometraje" type="number" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition" value="{{ old('kilometraje', $vehiculo?->kilometraje ?? 0) }}" placeholder="0">
            @error('kilometraje')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="flex items-center gap-3 pt-4 mt-2 border-t border-white/[0.06]">
        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-lg shadow-blue-500/25 cursor-pointer">
            {{ $vehiculo ? 'Guardar cambios' : 'Registrar vehiculo' }}
        </button>
        <a href="{{ route('panel.vehiculos.index') }}" class="px-6 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
    </div>
</div>

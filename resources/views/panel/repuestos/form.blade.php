@props(['repuesto' => null, 'categorias', 'proveedores'])

<div class="grid sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Codigo *</label>
        <input name="codigo" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('codigo', $repuesto?->codigo) }}" required placeholder="Ej: REP-001">
        @error('codigo')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Nombre *</label>
        <input name="nombre" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('nombre', $repuesto?->nombre) }}" required placeholder="Nombre del repuesto">
        @error('nombre')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Categoria</label>
        @if($categorias->count() > 0)
        <select name="categoria_id" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
            <option value="" class="bg-[#1a1a1a]">Sin categoria</option>
            @foreach($categorias as $c)
                <option value="{{ $c->id }}" class="bg-[#1a1a1a]" {{ old('categoria_id', $repuesto?->categoria_id) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
            @endforeach
        </select>
        @else
        <div class="p-3 rounded-xl bg-amber-500/10 border border-amber-500/20 text-sm">
            <p class="text-amber-400">Debe registrar al menos una categoria.</p>
            <a href="{{ route('panel.categorias.create') }}" class="text-blue-400 hover:text-blue-300 transition text-xs font-medium">Ir a crear categoria</a>
        </div>
        @endif
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Proveedor *</label>
        @if($proveedores->count() > 0)
        <select name="proveedor_id" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
            <option value="" class="bg-[#1a1a1a]">Seleccionar</option>
            @foreach($proveedores as $p)
                <option value="{{ $p->id }}" class="bg-[#1a1a1a]" {{ old('proveedor_id', $repuesto?->proveedor_id) == $p->id ? 'selected' : '' }}>{{ $p->nombre }}</option>
            @endforeach
        </select>
        @else
        <div class="p-3 rounded-xl bg-amber-500/10 border border-amber-500/20 text-sm">
            <p class="text-amber-400">Debe registrar al menos un proveedor.</p>
            <a href="{{ route('panel.proveedores.create') }}" class="text-blue-400 hover:text-blue-300 transition text-xs font-medium">Ir a crear proveedor</a>
        </div>
        @endif
        @error('proveedor_id')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Precio compra *</label>
        <input name="precio_compra" type="number" step="0.01" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('precio_compra', $repuesto?->precio_compra) }}" required placeholder="0.00">
        @error('precio_compra')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Precio venta *</label>
        <input name="precio_venta" type="number" step="0.01" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('precio_venta', $repuesto?->precio_venta) }}" required placeholder="0.00">
        @error('precio_venta')<p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Unidad medida</label>
        <input name="unidad_medida" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="{{ old('unidad_medida', $repuesto?->unidad_medida ?? 'unidad') }}" placeholder="unidad">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Descripcion</label>
        <textarea name="descripcion" rows="3" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" placeholder="Descripcion opcional">{{ old('descripcion', $repuesto?->descripcion) }}</textarea>
    </div>
</div>

<div class="flex items-center gap-3 pt-4 mt-2 border-t border-white/[0.06]">
    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">
        {{ $repuesto ? 'Guardar cambios' : 'Registrar repuesto' }}
    </button>
    <a href="{{ route('panel.repuestos.index') }}" class="px-6 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
</div>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['repuesto' => null, 'categorias', 'proveedores', 'tipoCambio' => 10.71]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['repuesto' => null, 'categorias', 'proveedores', 'tipoCambio' => 10.71]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="grid sm:grid-cols-2 gap-5" x-data="{
    moneda: '<?php echo e(old('moneda_compra', $repuesto?->moneda_compra ?? 'Bs')); ?>',
    precioOriginal: '<?php echo e(old('precio_compra_original', $repuesto?->precio_compra_original ?? $repuesto?->precio_compra ?? '')); ?>',
    tipoCambio: <?php echo e($tipoCambio); ?>,
    get precioBs() {
        if (!this.precioOriginal || this.precioOriginal <= 0) return 0;
        if (this.moneda === 'Bs') return parseFloat(this.precioOriginal);
        return parseFloat(this.precioOriginal) * this.tipoCambio;
    }
}">
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Codigo *</label>
        <input name="codigo" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="<?php echo e(old('codigo', $repuesto?->codigo)); ?>" required placeholder="Ej: REP-001">
        <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Nombre *</label>
        <input name="nombre" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="<?php echo e(old('nombre', $repuesto?->nombre)); ?>" required placeholder="Nombre del repuesto">
        <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Categoria</label>
        <?php if($categorias->count() > 0): ?>
        <select name="categoria_id" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
            <option value="" class="bg-[#1a1a1a]">Sin categoria</option>
            <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($c->id); ?>" class="bg-[#1a1a1a]" <?php echo e(old('categoria_id', $repuesto?->categoria_id) == $c->id ? 'selected' : ''); ?>><?php echo e($c->nombre); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php else: ?>
        <div class="p-3 rounded-xl bg-amber-500/10 border border-amber-500/20 text-sm">
            <p class="text-amber-400">Debe registrar al menos una categoria.</p>
            <a href="<?php echo e(route('panel.categorias.create')); ?>" class="text-blue-400 hover:text-blue-300 transition text-xs font-medium">Ir a crear categoria</a>
        </div>
        <?php endif; ?>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Proveedor *</label>
        <?php if($proveedores->count() > 0): ?>
        <select name="proveedor_id" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
            <option value="" class="bg-[#1a1a1a]">Seleccionar</option>
            <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p->id); ?>" class="bg-[#1a1a1a]" <?php echo e(old('proveedor_id', $repuesto?->proveedor_id) == $p->id ? 'selected' : ''); ?>><?php echo e($p->nombre); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php else: ?>
        <div class="p-3 rounded-xl bg-amber-500/10 border border-amber-500/20 text-sm">
            <p class="text-amber-400">Debe registrar al menos un proveedor.</p>
            <a href="<?php echo e(route('panel.proveedores.create')); ?>" class="text-blue-400 hover:text-blue-300 transition text-xs font-medium">Ir a crear proveedor</a>
        </div>
        <?php endif; ?>
        <?php $__errorArgs = ['proveedor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Precio de compra con moneda -->
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Precio de compra</label>
        <div class="grid sm:grid-cols-4 gap-3">
            <div class="sm:col-span-2">
                <input name="precio_compra_original" type="number" step="0.01" min="0" x-model="precioOriginal"
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                       placeholder="0.00">
                <input type="hidden" name="precio_compra" :value="precioBs.toFixed(2)">
            </div>
            <div>
                <select name="moneda_compra" x-model="moneda" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                    <option value="Bs" class="bg-[#1a1a1a]">Bolivianos (Bs)</option>
                    <option value="USD" class="bg-[#1a1a1a]">Dolares (USD)</option>
                </select>
            </div>
            <div>
                <div class="px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-sm text-gray-400 h-full">
                    <template x-if="moneda === 'Bs'">
                        <span>Bs <span x-text="precioOriginal ? parseFloat(precioOriginal).toFixed(2) : '0.00'"></span></span>
                    </template>
                    <template x-if="moneda === 'USD'">
                        <span>Bs <span x-text="precioBs.toFixed(2)"></span> <span class="text-gray-600">({{ tipoCambio }})</span></span>
                    </template>
                </div>
            </div>
        </div>
        <?php $__errorArgs = ['precio_compra'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Precio venta *</label>
        <input name="precio_venta" type="number" step="0.01" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="<?php echo e(old('precio_venta', $repuesto?->precio_venta)); ?>" required placeholder="0.00">
        <?php $__errorArgs = ['precio_venta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Unidad medida</label>
        <input name="unidad_medida" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="<?php echo e(old('unidad_medida', $repuesto?->unidad_medida ?? 'unidad')); ?>" placeholder="unidad">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1.5">Descripcion</label>
        <textarea name="descripcion" rows="3" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" placeholder="Descripcion opcional"><?php echo e(old('descripcion', $repuesto?->descripcion)); ?></textarea>
    </div>
</div>

<div class="flex items-center gap-3 pt-4 mt-2 border-t border-white/[0.06]">
    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">
        <?php echo e($repuesto ? 'Guardar cambios' : 'Registrar repuesto'); ?>

    </button>
    <a href="<?php echo e(route('panel.repuestos.index')); ?>" class="px-6 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
</div>
<?php /**PATH C:\laragon\www\TallerPro\resources\views/panel/repuestos/form.blade.php ENDPATH**/ ?>
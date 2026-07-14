<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['item' => null]));

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

foreach (array_filter((['item' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div>
    <label class="block text-sm font-medium text-gray-300 mb-1.5">Nombre *</label>
    <input name="nombre" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="<?php echo e(old('nombre', $item?->nombre)); ?>" required placeholder="Ej: Filtros">
    <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<div class="mt-5">
    <label class="block text-sm font-medium text-gray-300 mb-1.5">Descripcion</label>
    <textarea name="descripcion" rows="2" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" placeholder="Opcional"><?php echo e(old('descripcion', $item?->descripcion)); ?></textarea>
</div>
<div class="flex items-center gap-3 pt-4 mt-5 border-t border-white/[0.06]">
    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer"><?php echo e($item ? 'Guardar' : 'Crear categoria'); ?></button>
    <a href="<?php echo e(route('panel.categorias.index')); ?>" class="px-6 py-2.5 bg-white/5 border border-white/10 text-gray-300 text-sm font-medium rounded-full transition">Cancelar</a>
</div>
<?php /**PATH C:\laragon\www\TallerPro\resources\views/panel/categorias/form.blade.php ENDPATH**/ ?>
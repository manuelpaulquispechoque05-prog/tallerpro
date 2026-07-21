<?php $__env->startSection('title', 'Repuestos'); ?>

<?php $__env->startSection('content'); ?>
<!-- Header -->
<div class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="flex-1">
        <form method="GET" action="<?php echo e(route('panel.repuestos.index')); ?>" class="flex flex-wrap gap-3 items-end">
            <div class="relative flex-1 min-w-[200px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="busqueda" value="<?php echo e($busqueda); ?>" placeholder="Buscar repuesto..." class="w-full pl-10 pr-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1">Desde</label>
                <input type="date" name="desde" value="<?php echo e(request('desde')); ?>" class="px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1">Hasta</label>
                <input type="date" name="hasta" value="<?php echo e(request('hasta')); ?>" class="px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1">Mes</label>
                <select name="mes" class="px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white">
                    <option value="" class="bg-[#1a1a1a]">Todos</option>
                    <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($m); ?>" class="bg-[#1a1a1a]" <?php echo e(request('mes') == $m ? 'selected' : ''); ?>><?php echo e(DateTime::createFromFormat('!m', $m)->format('F')); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1">Anio</label>
                <select name="anio" class="px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white">
                    <option value="" class="bg-[#1a1a1a]">Todos</option>
                    <?php $__currentLoopData = range(now()->year, now()->year - 5, -1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($y); ?>" class="bg-[#1a1a1a]" <?php echo e(request('anio') == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-semibold rounded-xl transition cursor-pointer">Filtrar</button>
                <a href="<?php echo e(route('panel.repuestos.index')); ?>" class="px-4 py-2 bg-white/5 border border-white/10 text-gray-300 text-xs font-medium rounded-xl transition">Limpiar</a>
            </div>
        </form>
    </div>
    <a href="<?php echo e(route('panel.repuestos.create')); ?>" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-blue-500/25 shrink-0">Nuevo repuesto</a>
</div>

<?php if(session('success')): ?><div class="mb-6 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400"><?php echo e(session('success')); ?></div><?php endif; ?>

<!-- Catalog Grid -->
<?php if($repuestos->count() > 0): ?>
<div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 2xl:grid-cols-6 gap-3">
    <?php $__currentLoopData = $repuestos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $inv = $r->inventario; $alerta = $inv && $inv->stock_actual <= $inv->stock_minimo; ?>
    <div class="glass-card rounded-xl overflow-hidden hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-300 group">
        <div class="p-3">
            <div class="flex items-start justify-between gap-2 mb-2">
                <div class="flex items-center gap-2 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-mono text-gray-500 truncate"><?php echo e($r->codigo); ?></p>
                        <h4 class="text-sm font-semibold text-gray-100 leading-tight truncate"><?php echo e($r->nombre); ?></h4>
                    </div>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium shrink-0 <?php echo e($r->activo ? 'bg-green-500/10 text-green-400' : 'bg-gray-500/10 text-gray-400'); ?>"><?php echo e($r->activo ? 'Activo' : 'Inactivo'); ?></span>
            </div>
            <div class="flex flex-wrap gap-1 mb-2">
                <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-500/10 text-blue-400"><?php echo e($r->categoria?->nombre ?? 'General'); ?></span>
                <span class="text-[10px] px-2 py-0.5 rounded-full bg-gray-500/10 text-gray-400"><?php echo e($r->proveedor?->nombre ?? '—'); ?></span>
            </div>
            <div class="flex items-center justify-between pt-2 border-t border-white/[0.06]">
                <div>
                    <span class="text-sm font-bold text-white">Bs <?php echo e(number_format($r->precio_venta, 2)); ?></span>
                </div>
                <div>
                    <?php if($inv): ?>
                        <span class="text-xs font-medium <?php echo e($alerta ? 'text-red-400' : 'text-green-400'); ?>"><?php echo e($inv->stock_actual); ?> en stock</span>
                    <?php else: ?>
                        <span class="text-xs text-gray-600">Sin stock</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mt-2 pt-2 border-t border-white/[0.04] flex items-center justify-between">
                <a href="<?php echo e(route('panel.repuestos.show', $r->id)); ?>" class="text-xs text-blue-400 hover:text-blue-300 transition">Ver detalle</a>
                <div class="flex gap-1">
                    <a href="<?php echo e(route('panel.repuestos.edit', $r->id)); ?>" class="p-1.5 rounded-lg hover:bg-white/10 transition text-gray-500 hover:text-yellow-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                    <form method="POST" action="<?php echo e(route('panel.repuestos.destroy', $r->id)); ?>" onsubmit="return confirm('Eliminar?')" class="inline"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="p-1.5 rounded-lg hover:bg-white/10 transition text-gray-500 hover:text-red-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php else: ?>
<div class="glass-card rounded-2xl p-10 text-center">
    <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
    <p class="text-sm text-gray-500">No hay repuestos registrados</p>
</div>
<?php endif; ?>

<?php if($repuestos->hasPages()): ?><div class="mt-6"><?php echo e($repuestos->links()); ?></div><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TallerPro\resources\views/panel/repuestos/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Mecanicos'); ?>
<?php $__env->startSection('content'); ?>
<div class="glass-card rounded-2xl overflow-hidden">
    <div class="px-5 lg:px-6 py-4 border-b border-white/[0.06] flex items-center justify-between">
        <div><h3 class="text-sm font-semibold text-gray-100">Mecanicos</h3><p class="text-xs text-gray-500 mt-0.5">Personal del taller</p></div>
        <a href="<?php echo e(route('panel.mecanicos.create')); ?>" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-blue-500/25">Nuevo mecanico</a>
    </div>
    <div class="px-5 lg:px-6 py-3 border-b border-white/[0.06]">
        <form method="GET" x-data>
            <div class="relative max-w-md">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="busqueda" value="<?php echo e(request('busqueda')); ?>" placeholder="Buscar mecanico..." class="w-full pl-10 pr-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" x-on:input.debounce.500ms="$el.form.submit()">
            </div>
        </form>
    </div>
    <?php if(session('success')): ?><div class="mx-5 lg:mx-6 mt-4 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400"><?php echo e(session('success')); ?></div><?php endif; ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-white/[0.04]">
                <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Nombre</th>
                <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Especialidad</th>
                <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Sucursal</th>
                <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase text-gray-600">Telefono</th>
                <th class="px-5 py-3.5 text-center text-[10px] font-semibold uppercase text-gray-600">Estado</th>
                <th class="px-5 py-3.5 text-right text-[10px] font-semibold uppercase text-gray-600">Accion</th>
            </tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-b border-white/[0.03] hover:bg-white/[0.02]">
                    <td class="px-5 py-4"><span class="text-sm font-medium text-gray-200"><?php echo e($i->nombre_completo); ?></span></td>
                    <td class="px-5 py-4 text-sm text-gray-400"><?php echo e($i->especialidad?->nombre ?? '—'); ?></td>
                    <td class="px-5 py-4 text-sm text-gray-500"><?php echo e($i->sucursal?->nombre ?? '—'); ?></td>
                    <td class="px-5 py-4 text-sm text-gray-500"><?php echo e($i->telefono ?? '—'); ?></td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium <?php echo e($i->activo ? 'bg-green-500/10 text-green-400' : 'bg-gray-500/10 text-gray-400'); ?>"><?php echo e($i->activo ? 'Activo' : 'Inactivo'); ?></span>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <a href="<?php echo e(route('panel.mecanicos.show', $i->id)); ?>" class="p-2 rounded-lg hover:bg-white/10 transition text-gray-400 hover:text-blue-400 inline-block"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a>
                        <a href="<?php echo e(route('panel.mecanicos.edit', $i->id)); ?>" class="p-2 rounded-lg hover:bg-white/10 transition text-gray-400 hover:text-yellow-400 inline-block"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                        <form method="POST" action="<?php echo e(route('panel.mecanicos.destroy', $i->id)); ?>" onsubmit="return confirm('Eliminar mecanico?')" class="inline"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="p-2 rounded-lg hover:bg-white/10 transition text-gray-400 hover:text-red-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="px-5 py-10 text-center text-sm text-gray-500">No hay mecanicos registrados</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($items->hasPages()): ?><div class="px-5 lg:px-6 py-4 border-t border-white/[0.06]"><?php echo e($items->links()); ?></div><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TallerPro\resources\views/panel/mecanicos/index.blade.php ENDPATH**/ ?>
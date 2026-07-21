<?php $__env->startSection('title', 'Orden #' . $orden->id); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8 mb-6">
        <div class="flex flex-col sm:flex-row items-start justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shrink-0">#<?php echo e($orden->id); ?></div>
                <div>
                    <h1 class="text-xl font-bold text-white">Orden de trabajo #<?php echo e($orden->id); ?></h1>
                    <p class="text-sm text-gray-400 mt-0.5"><?php echo e($orden->cliente?->nombre_completo ?? '—'); ?></p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <?php
                            $colEst = ['pendiente' => 'bg-yellow-500/10 text-yellow-400', 'en_proceso' => 'bg-blue-500/10 text-blue-400', 'completado' => 'bg-green-500/10 text-green-400', 'cancelado' => 'bg-gray-500/10 text-gray-400'];
                        ?>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium <?php echo e($colEst[$orden->estado] ?? ''); ?>"><?php echo e(ucfirst($orden->estado)); ?></span>
                        <span class="text-xs text-gray-500 font-mono"><?php echo e($orden->vehiculo?->placa ?? '—'); ?></span>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <?php if($orden->estado === 'pendiente'): ?>
                    <form method="POST" action="<?php echo e(route('panel.ordenes.iniciar', $orden->id)); ?>" class="inline"><?php echo csrf_field(); ?><button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">Iniciar trabajo</button></form>
                    <form method="POST" action="<?php echo e(route('panel.ordenes.cancelar', $orden->id)); ?>" onsubmit="return confirm('Cancelar esta orden?')" class="inline"><?php echo csrf_field(); ?><button type="submit" class="px-4 py-2 bg-white/5 border border-white/10 text-gray-300 text-xs font-medium rounded-full transition cursor-pointer">Cancelar</button></form>
                <?php endif; ?>
                <?php if($orden->estado === 'en_proceso'): ?>
                    <form method="POST" action="<?php echo e(route('panel.ordenes.completar', $orden->id)); ?>" onsubmit="return confirm('Marcar como completada?')" class="inline"><?php echo csrf_field(); ?><button type="submit" class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-green-500/25 cursor-pointer">Completar</button></form>
                <?php endif; ?>
                <a href="<?php echo e(route('panel.ordenes.index')); ?>" class="px-4 py-2 bg-white/5 border border-white/10 text-gray-300 text-xs font-medium rounded-full transition">Volver</a>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?><div class="mb-6 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400"><?php echo e(session('success')); ?></div><?php endif; ?>
    <?php if(session('error')): ?><div class="mb-6 p-3 bg-red-500/10 border border-red-500/20 rounded-xl text-sm text-red-400"><?php echo e(session('error')); ?></div><?php endif; ?>

    <!-- Info -->
    <div class="grid lg:grid-cols-2 gap-4 mb-6">
        <div class="animate-in animate-in-d2 glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-sm font-semibold text-gray-100 mb-4">Informacion general</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-white/[0.04]"><span class="text-gray-500">Cliente</span><span class="text-gray-200"><?php echo e($orden->cliente?->nombre_completo ?? '—'); ?></span></div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]"><span class="text-gray-500">Vehiculo</span><span class="text-gray-200"><?php echo e($orden->vehiculo?->placa ?? '—'); ?> (<?php echo e($orden->vehiculo?->marca?->nombre ?? ''); ?> <?php echo e($orden->vehiculo?->modelo?->nombre ?? ''); ?>)</span></div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]"><span class="text-gray-500">Mecanico</span><span class="text-gray-200"><?php echo e($orden->mecanico?->nombre_completo ?? '—'); ?></span></div>
                <div class="flex justify-between py-2"><span class="text-gray-500">Creado por</span><span class="text-gray-200"><?php echo e($orden->creador?->name ?? '—'); ?></span></div>
            </div>
        </div>
        <div class="animate-in animate-in-d3 glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-sm font-semibold text-gray-100 mb-4">Fechas y total</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-white/[0.04]"><span class="text-gray-500">Ingreso</span><span class="text-gray-200"><?php echo e($orden->fecha_ingreso?->format('d/m/Y H:i') ?? '—'); ?></span></div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]"><span class="text-gray-500">Entrega estimada</span><span class="text-gray-200"><?php echo e($orden->fecha_estimada_entrega?->format('d/m/Y') ?? '—'); ?></span></div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]"><span class="text-gray-500">Finalizada</span><span class="text-gray-200"><?php echo e($orden->fecha_entrega?->format('d/m/Y H:i') ?? '—'); ?></span></div>
                <div class="flex justify-between pt-2"><span class="text-gray-500">Total</span><span class="text-lg font-bold text-white">Bs <?php echo e(number_format($orden->total, 2)); ?></span></div>
            </div>
        </div>
    </div>

    <?php if($orden->observaciones): ?>
    <div class="animate-in animate-in-d4 glass-card rounded-2xl p-5 lg:p-6 mb-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-2">Observaciones</h2>
        <p class="text-sm text-gray-400"><?php echo e($orden->observaciones); ?></p>
    </div>
    <?php endif; ?>

    <!-- Servicios -->
    <div class="animate-in animate-in-d5 glass-card rounded-2xl p-5 lg:p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-100">Servicios</h2>
            <?php if(!in_array($orden->estado, ['completado', 'cancelado'])): ?>
            <form method="POST" action="<?php echo e(route('panel.ordenes.servicios.store', $orden->id)); ?>" class="flex gap-2 items-end">
                <?php echo csrf_field(); ?>
                <div>
                    <select name="servicio_id" required class="px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <option value="" class="bg-[#1a1a1a]">Agregar servicio</option>
                        <?php $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s->id); ?>" class="bg-[#1a1a1a]"><?php echo e($s->nombre); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit" class="px-3 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-semibold rounded-xl transition cursor-pointer">Agregar</button>
            </form>
            <?php endif; ?>
        </div>
        <?php if($orden->detalleServicios->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b border-white/[0.04]">
                    <th class="px-4 py-2.5 text-left text-[10px] font-semibold uppercase text-gray-600">Servicio</th>
                    <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Precio</th>
                    <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Cant</th>
                    <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Subtotal</th>
                    <?php if(!in_array($orden->estado, ['completado', 'cancelado'])): ?><th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Accion</th><?php endif; ?>
                </tr></thead>
                <tbody>
                    <?php $__currentLoopData = $orden->detalleServicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b border-white/[0.03]">
                        <td class="px-4 py-3 text-gray-300"><?php echo e($d->servicio?->nombre ?? '—'); ?></td>
                        <td class="px-4 py-3 text-right text-gray-400">Bs <?php echo e(number_format($d->precio_unitario, 2)); ?></td>
                        <td class="px-4 py-3 text-right text-gray-400"><?php echo e($d->cantidad); ?></td>
                        <td class="px-4 py-3 text-right text-gray-200 font-medium">Bs <?php echo e(number_format($d->subtotal, 2)); ?></td>
                        <?php if(!in_array($orden->estado, ['completado', 'cancelado'])): ?>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="<?php echo e(route('panel.ordenes.servicios.destroy', [$orden->id, $d->id])); ?>" onsubmit="return confirm('Eliminar este servicio?')" class="inline"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="text-xs text-red-400 hover:text-red-300 transition cursor-pointer">Eliminar</button></form>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="text-sm text-gray-500 text-center py-4">Sin servicios registrados</p>
        <?php endif; ?>
    </div>

    <!-- Repuestos -->
    <div class="animate-in animate-in-d6 glass-card rounded-2xl p-5 lg:p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-100">Repuestos</h2>
            <?php if(!in_array($orden->estado, ['completado', 'cancelado'])): ?>
            <form method="POST" action="<?php echo e(route('panel.ordenes.repuestos.store', $orden->id)); ?>" class="flex gap-2 items-end">
                <?php echo csrf_field(); ?>
                <div><select name="repuesto_id" required class="px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50"><option value="" class="bg-[#1a1a1a]">Agregar repuesto</option><?php $__currentLoopData = $repuestos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($r->id); ?>" class="bg-[#1a1a1a]"><?php echo e($r->nombre); ?> (Bs <?php echo e(number_format($r->precio_venta, 2)); ?>)</option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
                <div><input name="cantidad" type="number" min="1" value="1" class="w-16 px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-xs text-white"></div>
                <button type="submit" class="px-3 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs font-semibold rounded-xl transition cursor-pointer">Agregar</button>
            </form>
            <?php endif; ?>
        </div>
        <?php if($orden->detalleRepuestos->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b border-white/[0.04]">
                    <th class="px-4 py-2.5 text-left text-[10px] font-semibold uppercase text-gray-600">Repuesto</th>
                    <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Precio</th>
                    <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Cant</th>
                    <th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Subtotal</th>
                    <?php if(!in_array($orden->estado, ['completado', 'cancelado'])): ?><th class="px-4 py-2.5 text-right text-[10px] font-semibold uppercase text-gray-600">Accion</th><?php endif; ?>
                </tr></thead>
                <tbody>
                    <?php $__currentLoopData = $orden->detalleRepuestos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b border-white/[0.03]">
                        <td class="px-4 py-3 text-gray-300"><?php echo e($d->repuesto?->nombre ?? '—'); ?></td>
                        <td class="px-4 py-3 text-right text-gray-400">Bs <?php echo e(number_format($d->precio_unitario, 2)); ?></td>
                        <td class="px-4 py-3 text-right text-gray-400"><?php echo e($d->cantidad); ?></td>
                        <td class="px-4 py-3 text-right text-gray-200 font-medium">Bs <?php echo e(number_format($d->subtotal, 2)); ?></td>
                        <?php if(!in_array($orden->estado, ['completado', 'cancelado'])): ?>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="<?php echo e(route('panel.ordenes.repuestos.destroy', [$orden->id, $d->id])); ?>" onsubmit="return confirm('Eliminar este repuesto?')" class="inline"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="text-xs text-red-400 hover:text-red-300 transition cursor-pointer">Eliminar</button></form>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="text-sm text-gray-500 text-center py-4">Sin repuestos registrados</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TallerPro\resources\views/panel/ordenes/show.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Cita #' . $cita->id); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8 mb-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-2xl font-bold shadow-xl shadow-blue-500/20 shrink-0">
                #<?php echo e($cita->id); ?>

            </div>
            <div class="text-center sm:text-left flex-1">
                <h1 class="text-xl font-bold text-white">Cita #<?php echo e($cita->id); ?></h1>
                <p class="text-sm text-gray-400 mt-1"><?php echo e($cita->cliente?->nombre_completo ?? '—'); ?></p>
                <div class="flex flex-wrap gap-2 mt-3 justify-center sm:justify-start">
                    <?php
                        $colores = [
                            'pendiente' => 'bg-yellow-500/10 text-yellow-400',
                            'confirmada' => 'bg-blue-500/10 text-blue-400',
                            'asignada' => 'bg-purple-500/10 text-purple-400',
                            'completada' => 'bg-green-500/10 text-green-400',
                            'cancelada' => 'bg-gray-500/10 text-gray-400',
                        ];
                    ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium <?php echo e($colores[$cita->estado] ?? ''); ?>">
                        <?php echo e(ucfirst($cita->estado)); ?>

                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400">
                        <?php echo e($cita->tipo_solicitud === 'servicio' ? 'Servicio' : 'Diagnostico'); ?>

                    </span>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 shrink-0 justify-center">
                <?php if($cita->estado === 'pendiente'): ?>
                    <a href="<?php echo e(route('panel.citas.confirmar', $cita->id)); ?>" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-blue-500/25" onclick="return confirm('Confirmar esta cita?')">Confirmar cita</a>
                <?php endif; ?>
                <?php if(in_array($cita->estado, ['pendiente', 'confirmada'])): ?>
                    <a href="<?php echo e(route('panel.citas.cancelar', $cita->id)); ?>" class="inline-flex items-center px-4 py-2 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-400 text-xs font-medium rounded-full transition" onclick="return confirm('Cancelar esta cita?')">Cancelar</a>
                <?php endif; ?>
                <?php if($cita->estado === 'confirmada' && !$cita->vehiculo_id): ?>
                    <a href="<?php echo e(route('panel.vehiculos.create', ['cliente_id' => $cita->cliente_id, 'cita_id' => $cita->id])); ?>" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-500 text-white text-xs font-semibold rounded-full transition shadow-lg shadow-amber-500/25">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Registrar vehiculo
                    </a>
                <?php endif; ?>
                <a href="<?php echo e(route('panel.citas.index')); ?>" class="inline-flex items-center px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-xs font-medium rounded-full transition">Volver</a>
            </div>
        </div>
    </div>

    <!-- Info -->
    <div class="grid lg:grid-cols-2 gap-4 mb-6">
        <div class="animate-in animate-in-d2 glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-sm font-semibold text-gray-100 mb-4">Detalles de la cita</h2>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Cliente</span>
                    <span class="text-sm text-gray-200"><?php echo e($cita->cliente?->nombre_completo ?? '—'); ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Tipo de solicitud</span>
                    <span class="text-sm text-gray-200"><?php echo e($cita->tipo_solicitud === 'servicio' ? 'Servicio' : 'Diagnostico'); ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Servicio</span>
                    <span class="text-sm text-gray-200"><?php echo e($cita->servicio?->nombre ?? '—'); ?></span>
                </div>
                <?php if($cita->descripcion_problema): ?>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Problema descrito</span>
                    <span class="text-sm text-gray-200"><?php echo e($cita->descripcion_problema); ?></span>
                </div>
                <?php endif; ?>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Vehiculo</span>
                    <span class="text-sm text-gray-200"><?php echo e($cita->tipoVehiculo?->nombre ?? '—'); ?></span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-xs text-gray-500">Duracion estimada</span>
                    <span class="text-sm text-gray-200"><?php echo e($cita->duracion_minutos); ?> min</span>
                </div>
            </div>
        </div>

        <div class="animate-in animate-in-d3 glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-sm font-semibold text-gray-100 mb-4">Agenda</h2>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Fecha</span>
                    <span class="text-sm text-gray-200"><?php echo e($cita->fecha_hora?->format('d/m/Y') ?? '—'); ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Hora</span>
                    <span class="text-sm text-gray-200"><?php echo e($cita->fecha_hora?->format('H:i') ?? '—'); ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/[0.04]">
                    <span class="text-xs text-gray-500">Mecanico asignado</span>
                    <span class="text-sm text-gray-200"><?php echo e($cita->mecanico?->nombre_completo ?? 'Pendiente'); ?></span>
                </div>
                <?php if($cita->ordenTrabajo): ?>
                <div class="flex justify-between py-2">
                    <span class="text-xs text-gray-500">Orden de trabajo</span>
                    <span class="text-sm text-blue-400">#<?php echo e($cita->ordenTrabajo->id); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ─── SECCION: ASIGNACION DE MECANICO (siempre visible) ──────── -->
    <div class="animate-in animate-in-d4 glass-card rounded-2xl p-5 lg:p-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Asignacion de mecanico</h2>

        <?php if($cita->estado === 'pendiente'): ?>
            <!-- Pendiente: primero hay que confirmar -->
            <div class="flex items-center gap-3 py-2">
                <svg class="w-5 h-5 text-gray-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-gray-500">Disponible despues de confirmar la cita.</p>
            </div>

        <?php elseif($cita->estado === 'confirmada' && !$cita->vehiculo_id): ?>
            <!-- Confirmada sin vehiculo: asignar mecanico + nota de vehiculo pendiente -->
            <form method="POST" action="<?php echo e(route('panel.citas.asignar-mecanico', $cita->id)); ?>" class="flex flex-col sm:flex-row gap-3 items-end mb-4">
                <?php echo csrf_field(); ?>
                <div class="flex-1 w-full">
                    <select name="mecanico_id" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <option value="" class="bg-[#1a1a1a]">Seleccionar mecanico</option>
                        <?php $__currentLoopData = $mecanicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m->id); ?>" class="bg-[#1a1a1a]"
                                <?php if($cita->mecanico_id === $m->id): echo 'selected'; endif; ?>
                                <?php if(!$m->disponible): echo 'disabled'; endif; ?>>
                                <?php echo e($m->nombre_completo); ?>

                                <?php if($m->disponible): ?> ✅ Disponible <?php else: ?> ❌ Ocupado <?php endif; ?>
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 w-full sm:w-auto cursor-pointer">Asignar</button>
            </form>
            <?php $__errorArgs = ['mecanico_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-sm text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <div class="flex items-center gap-3 p-3 rounded-xl border border-dashed border-amber-500/30 bg-amber-500/5">
                <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-gray-400">
                    Vehiculo pendiente de registro. Cuando el cliente llegue al taller, registra el vehiculo para crear la orden.
                </p>
            </div>

        <?php elseif($cita->estado === 'confirmada' && $cita->vehiculo_id): ?>
            <!-- Confirmada con vehiculo: asignar mecanico (crea orden al asignar) -->
            <form method="POST" action="<?php echo e(route('panel.citas.asignar-mecanico', $cita->id)); ?>" class="flex flex-col sm:flex-row gap-3 items-end">
                <?php echo csrf_field(); ?>
                <div class="flex-1 w-full">
                    <select name="mecanico_id" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <option value="" class="bg-[#1a1a1a]">Seleccionar mecanico</option>
                        <?php $__currentLoopData = $mecanicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m->id); ?>" class="bg-[#1a1a1a]"
                                <?php if($cita->mecanico_id === $m->id): echo 'selected'; endif; ?>
                                <?php if(!$m->disponible): echo 'disabled'; endif; ?>>
                                <?php echo e($m->nombre_completo); ?>

                                <?php if($m->disponible): ?> ✅ Disponible <?php else: ?> ❌ Ocupado <?php endif; ?>
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 w-full sm:w-auto cursor-pointer">Asignar</button>
            </form>
            <?php $__errorArgs = ['mecanico_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-sm text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <?php elseif($cita->estado === 'asignada' && !$cita->vehiculo_id): ?>
            <!-- Asignada sin vehiculo: esperando registro -->
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="flex-1">
                    <p class="text-sm text-gray-200">
                        Mecanico asignado: <span class="font-semibold text-white"><?php echo e($cita->mecanico?->nombre_completo ?? '—'); ?></span>
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Esperando que el cliente llegue al taller para registrar el vehiculo.</p>
                    <a href="<?php echo e(route('panel.vehiculos.create', ['cliente_id' => $cita->cliente_id, 'cita_id' => $cita->id])); ?>" class="inline-flex items-center gap-1.5 mt-3 px-4 py-2 bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/20 text-amber-400 text-xs font-medium rounded-full transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Registrar vehiculo
                    </a>
                </div>
            </div>

        <?php elseif($cita->estado === 'asignada' && $cita->vehiculo_id && !$cita->ordenTrabajo): ?>
            <!-- Asignada con vehiculo pero sin orden (creacion automatica pendiente) -->
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <p class="text-sm text-gray-200">
                        Mecanico asignado: <span class="font-semibold text-white"><?php echo e($cita->mecanico?->nombre_completo ?? '—'); ?></span>
                    </p>
                    <p class="text-sm text-amber-400 mt-1">Vehiculo registrado. La orden deberia crearse automaticamente.</p>
                </div>
            </div>

        <?php elseif($cita->estado === 'asignada' && $cita->ordenTrabajo && $cita->ordenTrabajo->estado === 'pendiente'): ?>
            <!-- Asignada con orden pendiente: reasignar -->
            <div class="flex items-center gap-2 mb-4">
                <span class="text-xs text-yellow-400 bg-yellow-500/10 px-2 py-0.5 rounded-full">La orden aun esta pendiente</span>
            </div>
            <form method="POST" action="<?php echo e(route('panel.citas.asignar-mecanico', $cita->id)); ?>" class="flex flex-col sm:flex-row gap-3 items-end">
                <?php echo csrf_field(); ?>
                <div class="flex-1 w-full">
                    <select name="mecanico_id" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <option value="" class="bg-[#1a1a1a]">Seleccionar mecanico</option>
                        <?php $__currentLoopData = $mecanicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m->id); ?>" class="bg-[#1a1a1a]"
                                <?php if($cita->mecanico_id === $m->id): echo 'selected'; endif; ?>
                                <?php if(!$m->disponible): echo 'disabled'; endif; ?>>
                                <?php echo e($m->nombre_completo); ?>

                                <?php if($m->disponible): ?> ✅ Disponible <?php else: ?> ❌ Ocupado <?php endif; ?>
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 w-full sm:w-auto cursor-pointer">Reasignar</button>
            </form>
            <?php $__errorArgs = ['mecanico_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-sm text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <?php elseif($cita->estado === 'asignada'): ?>
            <!-- Asignada con orden en_proceso/completada/cancelada: solo lectura -->
            <div class="flex items-center gap-3 py-2">
                <svg class="w-5 h-5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <p class="text-sm text-gray-200">
                        Mecanico asignado: <span class="font-semibold text-white"><?php echo e($cita->mecanico?->nombre_completo ?? '—'); ?></span>
                    </p>
                    <?php if($cita->ordenTrabajo && in_array($cita->ordenTrabajo->estado, ['completado', 'cancelado'])): ?>
                        <p class="text-xs text-gray-500 mt-0.5">No se puede cambiar el mecanico. La orden esta <?php echo e($cita->ordenTrabajo->estado); ?>.</p>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>
            <!-- Estados no contemplados (completada, cancelada, etc.) -->
            <div class="flex items-center gap-3 py-2">
                <svg class="w-5 h-5 text-gray-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-gray-500">
                    <?php if($cita->mecanico): ?>
                        Mecanico asignado: <?php echo e($cita->mecanico->nombre_completo); ?>

                    <?php else: ?>
                        No disponible.
                    <?php endif; ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TallerPro\resources\views/panel/citas/show.blade.php ENDPATH**/ ?>
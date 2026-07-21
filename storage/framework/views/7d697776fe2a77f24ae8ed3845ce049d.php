<?php $__env->startSection('title', 'Citas'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats -->
<div class="grid grid-cols-5 gap-3 mb-6">
    <?php
        $stats = [
            ['estado' => 'pendiente', 'label' => 'Pendientes', 'color' => 'text-yellow-400', 'bg' => 'bg-yellow-500/10'],
            ['estado' => 'confirmada', 'label' => 'Confirmadas', 'color' => 'text-blue-400', 'bg' => 'bg-blue-500/10'],
            ['estado' => 'asignada', 'label' => 'Asignadas', 'color' => 'text-purple-400', 'bg' => 'bg-purple-500/10'],
            ['estado' => 'completada', 'label' => 'Completadas', 'color' => 'text-green-400', 'bg' => 'bg-green-500/10'],
            ['estado' => 'cancelada', 'label' => 'Canceladas', 'color' => 'text-gray-400', 'bg' => 'bg-gray-500/10'],
        ];
        $counts = ['pendiente' => 0, 'confirmada' => 0, 'asignada' => 0, 'completada' => 0, 'cancelada' => 0];
        foreach ($citas as $c) { isset($counts[$c->estado]) && $counts[$c->estado]++; }
    ?>
    <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="glass-card rounded-2xl p-4 text-center">
        <p class="text-2xl font-bold <?php echo e($s['color']); ?>"><?php echo e($counts[$s['estado']]); ?></p>
        <p class="text-xs text-gray-500 mt-1"><?php echo e($s['label']); ?></p>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Filters -->
<div class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="flex-1">
        <form method="GET" x-data>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="busqueda" value="<?php echo e($busqueda); ?>" placeholder="Buscar por cliente..." class="w-full pl-10 pr-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" x-on:input.debounce.500ms="$el.form.submit()">
            </div>
        </form>
    </div>
    <select name="estado" onchange="this.form.submit()" form="filter-form" class="px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white">
        <option value="" class="bg-[#1a1a1a]">Todos los estados</option>
        <?php $__currentLoopData = ['pendiente', 'confirmada', 'asignada', 'completada', 'cancelada']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($est); ?>" class="bg-[#1a1a1a]" <?php echo e($estadoFiltro === $est ? 'selected' : ''); ?>><?php echo e(ucfirst($est)); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<?php if(session('success')): ?><div class="mb-6 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400"><?php echo e(session('success')); ?></div><?php endif; ?>
<?php if(session('error')): ?><div class="mb-6 p-3 bg-red-500/10 border border-red-500/20 rounded-xl text-sm text-red-400"><?php echo e(session('error')); ?></div><?php endif; ?>

<!-- Kanban Cards -->
<form id="filter-form" method="GET"></form>

<?php if($citas->count() > 0): ?>
<div class="space-y-3">
    <?php $__currentLoopData = $citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $colors = [
            'pendiente' => ['border' => 'border-l-yellow-500', 'dot' => 'bg-yellow-400', 'bg' => 'bg-yellow-500/10', 'text' => 'text-yellow-400'],
            'confirmada' => ['border' => 'border-l-blue-500', 'dot' => 'bg-blue-400', 'bg' => 'bg-blue-500/10', 'text' => 'text-blue-400'],
            'asignada' => ['border' => 'border-l-purple-500', 'dot' => 'bg-purple-400', 'bg' => 'bg-purple-500/10', 'text' => 'text-purple-400'],
            'completada' => ['border' => 'border-l-green-500', 'dot' => 'bg-green-400', 'bg' => 'bg-green-500/10', 'text' => 'text-green-400'],
            'cancelada' => ['border' => 'border-l-gray-500', 'dot' => 'bg-gray-400', 'bg' => 'bg-gray-500/10', 'text' => 'text-gray-400'],
        ];
        $co = $colors[$c->estado] ?? $colors['pendiente'];
    ?>
    <div class="glass-card rounded-2xl border-l-4 <?php echo e($co['border']); ?> p-5 hover:shadow-lg transition-all duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center text-sm font-bold text-blue-400 shrink-0">
                    <?php echo e(substr($c->cliente?->nombre ?? '?', 0, 1)); ?><?php echo e(substr($c->cliente?->apellido ?? '', 0, 1)); ?>

                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-100"><?php echo e($c->cliente?->nombre_completo ?? '—'); ?></p>
                    <div class="flex flex-wrap gap-2 mt-1">
                        <span class="text-xs text-gray-500"><?php echo e($c->servicio?->nombre ?? 'Diagnostico'); ?></span>
                        <span class="text-xs text-gray-600">•</span>
                        <span class="text-xs text-gray-500"><?php echo e($c->tipoVehiculo?->nombre ?? '—'); ?></span>
                        <span class="text-xs text-gray-600">•</span>
                        <span class="text-xs text-gray-400"><?php echo e($c->fecha_hora?->format('d/m/Y H:i') ?? '—'); ?></span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium <?php echo e($co['bg']); ?> <?php echo e($co['text']); ?>">
                    <span class="w-1.5 h-1.5 rounded-full <?php echo e($co['dot']); ?>"></span>
                    <?php echo e(ucfirst($c->estado)); ?>

                </span>
                <?php if($c->mecanico): ?>
                    <span class="text-xs text-gray-500"><?php echo e($c->mecanico->nombre_completo); ?></span>
                <?php endif; ?>
                <div class="flex gap-1">
                    <a href="<?php echo e(route('panel.citas.show', $c->id)); ?>" class="p-2 rounded-lg hover:bg-white/10 transition text-gray-500 hover:text-blue-400" title="Ver">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                    <?php if($c->estado === 'pendiente'): ?>
                    <a href="<?php echo e(route('panel.citas.confirmar', $c->id)); ?>" class="p-2 rounded-lg hover:bg-white/10 transition text-gray-500 hover:text-green-400" title="Confirmar" onclick="return confirm('Confirmar esta cita?')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php else: ?>
<div class="glass-card rounded-2xl p-10 text-center">
    <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
    <p class="text-sm text-gray-500">No hay citas registradas</p>
</div>
<?php endif; ?>

<?php if($citas->hasPages()): ?><div class="mt-6"><?php echo e($citas->links()); ?></div><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TallerPro\resources\views/panel/citas/index.blade.php ENDPATH**/ ?>
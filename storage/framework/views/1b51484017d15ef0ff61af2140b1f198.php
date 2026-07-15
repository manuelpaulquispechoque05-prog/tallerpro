<?php $__env->startSection('title', 'Mi cuenta'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white">Bienvenido, <?php echo e($user->name); ?></h1>
    <p class="text-sm text-gray-400 mt-1">Panel de cliente de Taller Pro</p>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="glass-card rounded-2xl p-5">
        <p class="text-2xl font-bold text-white"><?php echo e($cliente?->vehiculos?->count() ?? 0); ?></p>
        <p class="text-xs text-gray-500 mt-1">Vehiculos</p>
    </div>
    <div class="glass-card rounded-2xl p-5">
        <p class="text-2xl font-bold text-blue-400"><?php echo e($cliente?->citas?->count() ?? 0); ?></p>
        <p class="text-xs text-gray-500 mt-1">Citas</p>
    </div>
    <div class="glass-card rounded-2xl p-5">
        <p class="text-2xl font-bold text-amber-400"><?php echo e($cliente?->ordenesTrabajo?->count() ?? 0); ?></p>
        <p class="text-xs text-gray-500 mt-1">Ordenes</p>
    </div>
    <div class="glass-card rounded-2xl p-5">
        <p class="text-2xl font-bold text-green-400">—</p>
        <p class="text-xs text-gray-500 mt-1">Proximo servicio</p>
    </div>
</div>

<?php if(!$cliente): ?>
<div class="glass-card rounded-2xl p-6 text-center">
    <p class="text-sm text-gray-400">Aun no tienes un perfil de cliente completo.</p>
    <p class="text-xs text-gray-600 mt-1">Cuando registres tu primer vehiculo o reserves una cita, tus datos apareceran aqui.</p>
</div>
<?php endif; ?>

<div class="grid sm:grid-cols-2 gap-4 mb-6">
    <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all duration-300">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-100">Mis vehiculos</p>
                <p class="text-xs text-gray-500"><?php echo e($cliente?->vehiculos?->count() ?? 0); ?> registrados</p>
            </div>
        </div>
        <a href="<?php echo e(route('portal.vehiculos.index')); ?>" class="inline-flex items-center text-sm font-medium text-blue-400 hover:text-blue-300 transition gap-1">
            Ver vehiculos <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
    <div class="glass-card rounded-2xl p-5 opacity-60">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-600/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-100">Reservar cita</p>
                <p class="text-xs text-gray-500">Proximamente</p>
            </div>
        </div>
    </div>
</div>

<div class="glass-card rounded-2xl p-6">
    <h2 class="text-sm font-semibold text-gray-100 mb-4">Mis datos</h2>
    <div class="grid sm:grid-cols-2 gap-4 text-sm">
        <div><span class="text-gray-500">Nombre:</span> <span class="text-gray-200"><?php echo e($user->name); ?></span></div>
        <div><span class="text-gray-500">Email:</span> <span class="text-gray-200"><?php echo e($user->email); ?></span></div>
        <?php if($cliente): ?>
        <div><span class="text-gray-500">CI / NIT:</span> <span class="text-gray-200"><?php echo e($cliente->ci_nit); ?></span></div>
        <div><span class="text-gray-500">Telefono:</span> <span class="text-gray-200"><?php echo e($cliente->telefono); ?></span></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.portal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TallerPro\resources\views/portal/dashboard.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Editar repuesto'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <h1 class="text-sm font-semibold text-gray-100 mb-6">Editar repuesto: <?php echo e($repuesto->nombre); ?></h1>
        <form method="POST" action="<?php echo e(route('panel.repuestos.update', $repuesto->id)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <?php echo $__env->make('panel.repuestos.form', ['repuesto' => $repuesto, 'tipoCambio' => $tipoCambio], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TallerPro\resources\views/panel/repuestos/edit.blade.php ENDPATH**/ ?>
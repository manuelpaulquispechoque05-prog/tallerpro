<?php $__env->startSection('title', 'Editar categoria'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-lg mx-auto">
    <div class="animate-in glass-card rounded-2xl p-6 lg:p-8">
        <h1 class="text-sm font-semibold text-gray-100 mb-6">Editar categoria: <?php echo e($item->nombre); ?></h1>
        <form method="POST" action="<?php echo e(route('panel.categorias.update', $item->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?> <?php echo $__env->make('panel.categorias.form', ['item' => $item], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TallerPro\resources\views/panel/categorias/edit.blade.php ENDPATH**/ ?>
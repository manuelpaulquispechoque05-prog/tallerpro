<?php $__env->startSection('title', 'Mi perfil'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-white">Mi perfil</h1>
        <p class="text-sm text-gray-400 mt-1">Informacion personal de tu cuenta</p>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('status') === 'password-updated'): ?>
        <div class="mb-6 p-3 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400">Contrasena actualizada correctamente.</div>
    <?php endif; ?>

    <!-- Datos del usuario -->
    <div class="glass-card rounded-2xl p-6 lg:p-8 mb-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Datos de la cuenta</h2>
        <div class="grid sm:grid-cols-2 gap-4 text-sm">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Nombre completo</label>
                <div class="w-full px-4 py-3 bg-white/[0.03] border border-white/[0.06] rounded-xl text-gray-400 cursor-not-allowed"><?php echo e($cliente->nombre); ?> <?php echo e($cliente->apellido); ?></div>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Correo electronico</label>
                <div class="w-full px-4 py-3 bg-white/[0.03] border border-white/[0.06] rounded-xl text-gray-400 cursor-not-allowed"><?php echo e($user->email); ?></div>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">CI / NIT</label>
                <div class="w-full px-4 py-3 bg-white/[0.03] border border-white/[0.06] rounded-xl text-gray-400 cursor-not-allowed"><?php echo e($cliente->ci_nit); ?></div>
            </div>
        </div>
    </div>

    <!-- Datos editables -->
    <div class="glass-card rounded-2xl p-6 lg:p-8 mb-6">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Informacion de contacto</h2>
        <form method="POST" action="<?php echo e(route('portal.perfil.update')); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Telefono *</label>
                    <input name="telefono" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="<?php echo e(old('telefono', $cliente->telefono)); ?>" required>
                    <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Direccion</label>
                    <input name="direccion" type="text" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" value="<?php echo e(old('direccion', $cliente->direccion)); ?>" placeholder="Opcional">
                </div>
            </div>
            <div class="mt-6 pt-5 border-t border-white/[0.06]">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">Guardar cambios</button>
            </div>
        </form>
    </div>

    <!-- Seguridad -->
    <div class="glass-card rounded-2xl p-6 lg:p-8">
        <h2 class="text-sm font-semibold text-gray-100 mb-4">Seguridad</h2>
        <form method="POST" action="<?php echo e(route('password.update')); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

            <div class="grid sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Contrasena actual *</label>
                    <input name="current_password" type="password" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" required placeholder="Tu contrasena actual">
                    <?php $__errorArgs = ['current_password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Nueva contrasena *</label>
                    <input name="password" type="password" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" required placeholder="Min. 8 caracteres">
                    <?php $__errorArgs = ['password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Confirmar contrasena *</label>
                    <input name="password_confirmation" type="password" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50" required placeholder="Repite la contrasena">
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-white/[0.06]">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold rounded-full transition shadow-lg shadow-blue-500/25 cursor-pointer">Actualizar contrasena</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.portal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TallerPro\resources\views/portal/perfil.blade.php ENDPATH**/ ?>
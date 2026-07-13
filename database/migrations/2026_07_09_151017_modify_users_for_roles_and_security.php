<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar el campo rol simple de la Fase 0 si existe (ahora usamos RBAC)
            if (Schema::hasColumn('users', 'rol')) {
                $table->dropColumn('rol');
            }

            // Relacion con roles (RBAC)
            $table->foreignId('rol_id')
                ->nullable()
                ->constrained('roles')
                ->nullOnDelete();

            // Sucursal a la que pertenece el usuario
            $table->foreignId('sucursal_id')
                ->nullable()
                ->constrained('sucursales')
                ->nullOnDelete();

            // Campos de seguridad
            $table->boolean('activo')->default(true);
            $table->timestamp('ultimo_login_at')->nullable();
            $table->softDeletes(); // deleted_at — nunca borrar fisicamente
        });

        // CHECK constraint: debe tener password O provider, nunca ninguno de los dos
        DB::statement('ALTER TABLE users ADD CONSTRAINT chk_user_metodo_auth CHECK (password IS NOT NULL OR provider IS NOT NULL)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE users DROP CONSTRAINT chk_user_metodo_auth');

        Schema::table('users', function (Blueprint $table) {
            // MySQL exige eliminar las FK antes de dropear las columnas
            $table->dropForeign(['rol_id']);
            $table->dropForeign(['sucursal_id']);
            $table->dropSoftDeletes();
            $table->dropColumn(['ultimo_login_at', 'activo', 'sucursal_id', 'rol_id']);

            // Restaurar el campo rol simple por si se hace rollback
            $table->string('rol', 20)->default('operador');
        });
    }
};

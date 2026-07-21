<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Sincronizar citas que quedaron en "asignada" pero su orden ya fue completada.
        // Esto ocurrio antes de que existiera la sincronizacion automatica en
        // OrdenTrabajoService::completar().
        DB::statement("
            UPDATE citas
            SET estado = 'completada'
            WHERE estado = 'asignada'
            AND orden_trabajo_id IS NOT NULL
            AND EXISTS (
                SELECT 1 FROM ordenes_trabajo
                WHERE ordenes_trabajo.id = citas.orden_trabajo_id
                AND ordenes_trabajo.estado = 'completado'
            )
        ");
    }

    public function down(): void
    {
        // No se puede revertir: no sabemos cuales fueron cambiadas manualmente
        // vs cuales fueron cambiadas por esta migracion.
    }
};

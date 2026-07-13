<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tablas = [
        // Sin proteccion actual (ni activo ni softDeletes)
        'ordenes_trabajo',
        'citas',
        'pagos',
        'facturas',
        'detalle_orden_servicios',
        'detalle_orden_repuestos',
        'movimientos_inventario',
        'garantias',
        'notificaciones',
        'auditorias',
        'reportes',
        'horarios_mecanico',

        // Solo tienen activo (boolean), agregamos softDeletes para trazabilidad
        'clientes',
        'vehiculos',
        'mecanicos',
        'repuestos',
        'proveedores',
        'servicios',
        'sucursales',
    ];

    public function up(): void
    {
        foreach ($this->tablas as $tabla) {
            Schema::table($tabla, function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tablas as $tabla) {
            Schema::table($tabla, function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};

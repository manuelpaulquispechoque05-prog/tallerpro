<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->decimal('precio_unitario_original', 10, 2)->nullable()->after('cantidad');
            $table->string('moneda', 3)->nullable()->after('precio_unitario_original');
            $table->decimal('tipo_cambio', 8, 2)->nullable()->after('moneda');
            $table->decimal('precio_unitario_bs', 10, 2)->nullable()->after('tipo_cambio');
        });
    }

    public function down(): void
    {
        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->dropColumn(['precio_unitario_original', 'moneda', 'tipo_cambio', 'precio_unitario_bs']);
        });
    }
};

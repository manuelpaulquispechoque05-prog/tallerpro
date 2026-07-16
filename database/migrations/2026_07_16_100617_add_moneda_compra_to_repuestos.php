<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('repuestos', function (Blueprint $table) {
            $table->decimal('precio_compra_original', 10, 2)->nullable()->after('precio_compra');
            $table->string('moneda_compra', 3)->nullable()->after('precio_compra_original');
            $table->decimal('tipo_cambio_compra', 8, 2)->nullable()->after('moneda_compra');
        });
    }

    public function down(): void
    {
        Schema::table('repuestos', function (Blueprint $table) {
            $table->dropColumn(['precio_compra_original', 'moneda_compra', 'tipo_cambio_compra']);
        });
    }
};

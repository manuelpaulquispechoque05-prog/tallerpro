<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repuesto_id')
                ->constrained('repuestos')
                ->cascadeOnDelete();
            $table->foreignId('sucursal_id')
                ->constrained('sucursales')
                ->cascadeOnDelete();
            $table->integer('stock_actual')->default(0);
            $table->integer('stock_minimo')->default(5);
            $table->timestamp('updated_at')->useCurrent();

            $table->unique(['repuesto_id', 'sucursal_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};

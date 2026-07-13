<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_trabajo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->restrictOnDelete();
            $table->foreignId('vehiculo_id')
                ->constrained('vehiculos')
                ->restrictOnDelete();
            $table->foreignId('mecanico_id')
                ->nullable()
                ->constrained('mecanicos')
                ->nullOnDelete();
            $table->foreignId('sucursal_id')
                ->constrained('sucursales')
                ->restrictOnDelete();
            $table->foreignId('creado_por')
                ->constrained('users')
                ->restrictOnDelete();
            $table->string('estado', 20)->default('pendiente');
            $table->integer('kilometraje_ingreso')->unsigned();
            $table->text('observaciones')->nullable();
            $table->decimal('total', 10, 2)->default(0);
            $table->dateTime('fecha_ingreso');
            $table->dateTime('fecha_estimada_entrega')->nullable();
            $table->dateTime('fecha_entrega')->nullable();
            $table->timestamps();

            $table->index('estado');
            $table->index('fecha_ingreso');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_trabajo');
    }
};

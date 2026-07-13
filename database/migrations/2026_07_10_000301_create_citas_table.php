<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->cascadeOnDelete();
            $table->foreignId('vehiculo_id')
                ->constrained('vehiculos')
                ->cascadeOnDelete();
            $table->foreignId('mecanico_id')
                ->nullable()
                ->constrained('mecanicos')
                ->nullOnDelete();
            $table->foreignId('servicio_id')
                ->constrained('servicios')
                ->restrictOnDelete();
            $table->foreignId('sucursal_id')
                ->constrained('sucursales')
                ->restrictOnDelete();
            $table->foreignId('orden_trabajo_id')
                ->nullable()
                ->constrained('ordenes_trabajo')
                ->nullOnDelete();
            $table->smallInteger('duracion_minutos')->unsigned();
            $table->dateTime('fecha_hora');
            $table->string('estado', 20)->default('programada');
            $table->string('motivo', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};

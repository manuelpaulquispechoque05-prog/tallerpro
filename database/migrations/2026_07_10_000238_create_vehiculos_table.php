<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->restrictOnDelete();
            $table->foreignId('marca_id')
                ->constrained('marcas_vehiculo')
                ->restrictOnDelete();
            $table->foreignId('modelo_id')
                ->constrained('modelos_vehiculo')
                ->restrictOnDelete();
            $table->smallInteger('anio')->unsigned();
            $table->string('placa', 15)->unique();
            $table->string('vin', 17)->unique()->nullable();
            $table->string('color', 30)->nullable();
            $table->integer('kilometraje')->unsigned()->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};

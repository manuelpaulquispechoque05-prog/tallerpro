<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_trabajo_id')
                ->unique()
                ->constrained('ordenes_trabajo')
                ->restrictOnDelete();
            $table->string('numero_factura', 30)->unique();
            $table->string('nit_cliente', 20);
            $table->string('razon_social', 150);
            $table->decimal('monto_total', 10, 2);
            $table->string('estado', 20)->default('emitida');
            $table->dateTime('fecha_emision');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};

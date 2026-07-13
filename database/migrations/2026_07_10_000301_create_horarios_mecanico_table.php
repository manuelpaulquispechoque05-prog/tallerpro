<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios_mecanico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mecanico_id')
                ->constrained('mecanicos')
                ->cascadeOnDelete();
            $table->tinyInteger('dia_semana')->unsigned(); // 1=Lun ... 7=Dom
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->boolean('activo')->default(true);

            $table->unique(['mecanico_id', 'dia_semana']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios_mecanico');
    }
};

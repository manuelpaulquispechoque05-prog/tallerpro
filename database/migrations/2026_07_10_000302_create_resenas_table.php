<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->cascadeOnDelete();
            $table->foreignId('mecanico_id')
                ->constrained('mecanicos')
                ->cascadeOnDelete();
            $table->foreignId('orden_trabajo_id')
                ->unique()
                ->constrained('ordenes_trabajo')
                ->cascadeOnDelete();
            $table->tinyInteger('calificacion')->unsigned();
            $table->string('comentario', 500)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        DB::statement('ALTER TABLE resenas ADD CONSTRAINT chk_resena_calificacion CHECK (calificacion BETWEEN 1 AND 5)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE resenas DROP CONSTRAINT chk_resena_calificacion');
        Schema::dropIfExists('resenas');
    }
};

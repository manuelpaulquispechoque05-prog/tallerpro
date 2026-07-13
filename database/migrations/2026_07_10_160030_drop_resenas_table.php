<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('resenas');
    }

    public function down(): void
    {
        // No recreamos la tabla porque la definicion original se pierde al dropearla.
        // Si se necesita revertir, debe restaurarse desde la migracion original.
    }
};

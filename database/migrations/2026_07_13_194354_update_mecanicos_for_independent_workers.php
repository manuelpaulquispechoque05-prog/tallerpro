<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mecanicos', function (Blueprint $table) {
            $table->string('nombre', 100)->after('id');
            $table->string('apellidos', 100)->after('nombre');
            $table->string('ci', 20)->unique()->nullable()->after('apellidos');
            $table->string('telefono', 20)->nullable()->after('ci');
            $table->string('direccion', 255)->nullable()->after('telefono');
            $table->string('observaciones', 255)->nullable()->after('direccion');

            $table->foreignId('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('mecanicos', function (Blueprint $table) {
            $table->dropColumn(['nombre', 'apellidos', 'ci', 'telefono', 'direccion', 'observaciones']);
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};

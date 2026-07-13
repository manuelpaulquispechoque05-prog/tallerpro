<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->string('tipo_solicitud', 20)->after('vehiculo_id');
            $table->foreignId('tipo_vehiculo_id')->after('tipo_solicitud')
                ->constrained('tipos_vehiculo')
                ->restrictOnDelete();
            $table->text('descripcion_problema')->nullable()->after('tipo_vehiculo_id');

            $table->dropColumn('motivo');
        });

        DB::statement('ALTER TABLE citas MODIFY vehiculo_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE citas ALTER estado SET DEFAULT \'pendiente\'');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE citas MODIFY vehiculo_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE citas ALTER estado SET DEFAULT \'programada\'');

        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign(['tipo_vehiculo_id']);
            $table->dropColumn(['tipo_solicitud', 'tipo_vehiculo_id', 'descripcion_problema']);
            $table->string('motivo', 255)->nullable();
        });
    }
};

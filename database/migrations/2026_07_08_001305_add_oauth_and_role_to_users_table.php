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
        Schema::table('users', function (Blueprint $table) {
            // Hacemos password nullable porque el login con Google
            // no requiere contraseña — cada usuario puede tener solo un método de registro
            $table->string('password')->nullable()->change();

            // Columnas para autenticación OAuth (Google)
            $table->string('provider')->nullable()->after('remember_token');
            $table->string('provider_id')->nullable()->after('provider');
            $table->string('avatar')->nullable()->after('provider_id');

            // Evitar que un mismo Google ID cree múltiples cuentas
            $table->unique(['provider', 'provider_id']);

            // Rol del usuario: admin puede todo, operador tiene acceso limitado
            // Usamos string en vez de enum nativo de MySQL para evitar
            // migraciones complejas si en el futuro agregamos más roles
            $table->string('rol', 20)->default('operador')->after('avatar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable(false)->change();
            $table->dropColumn(['provider', 'provider_id', 'avatar', 'rol']);
        });
    }
};

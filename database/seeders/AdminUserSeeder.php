<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear rol Administrador si no existe
        $rolAdmin = DB::table('roles')->where('nombre', 'Administrador')->first();
        if (!$rolAdmin) {
            $rolAdminId = DB::table('roles')->insertGetId([
                'nombre' => 'Administrador',
                'descripcion' => 'Acceso completo al sistema',
            ]);
        } else {
            $rolAdminId = $rolAdmin->id;
        }

        // Crear rol Cliente si no existe
        $rolCliente = DB::table('roles')->where('nombre', 'Cliente')->first();
        if (!$rolCliente) {
            DB::table('roles')->insert([
                'nombre' => 'Cliente',
                'descripcion' => 'Acceso al portal del cliente',
            ]);
        }

        $plainPassword = 'Admin.2026';

        User::updateOrCreate(
            ['email' => 'paulquispechoque2018@gmail.com'],
            [
                'name' => 'Manuel Paul Quispe Choque',
                'password' => Hash::make($plainPassword),
                'rol_id' => $rolAdminId,
                'email_verified_at' => now(),
                'activo' => true,
            ]
        );

        $this->command->info('Usuario administrador creado exitosamente.');
        $this->command->warn('Contrasena de prueba: ' . $plainPassword);
    }
}

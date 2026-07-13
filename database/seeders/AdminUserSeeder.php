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
        $rol = DB::table('roles')->where('nombre', 'Administrador')->first();

        if (!$rol) {
            $rolId = DB::table('roles')->insertGetId([
                'nombre' => 'Administrador',
                'descripcion' => 'Acceso completo al sistema',
            ]);
        } else {
            $rolId = $rol->id;
        }

        $plainPassword = 'Admin.2026';

        User::updateOrCreate(
            ['email' => 'paulquispechoque2018@gmail.com'],
            [
                'name' => 'Manuel Paul Quispe Choque',
                'password' => Hash::make($plainPassword),
                'rol_id' => $rolId,
                'email_verified_at' => now(),
                'activo' => true,
            ]
        );

        $this->command->info('Usuario administrador creado exitosamente.');
        $this->command->warn('Contrasena de prueba: ' . $plainPassword);
    }
}

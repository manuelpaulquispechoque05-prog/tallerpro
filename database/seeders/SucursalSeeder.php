<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SucursalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sucursales')->updateOrInsert(
            ['id' => 1],
            [
                'nombre' => 'Principal',
                'direccion' => 'Av. Principal #123, Santa Cruz',
                'telefono' => '70000000',
                'ciudad' => 'Santa Cruz de la Sierra',
                'activo' => true,
            ]
        );

        $this->command->info('Sucursal Principal creada.');
    }
}

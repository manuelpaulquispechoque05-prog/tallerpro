<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoVehiculoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['Automovil', 'Motocicleta', 'Camioneta', 'Otro'];

        foreach ($tipos as $nombre) {
            if (!DB::table('tipos_vehiculo')->where('nombre', $nombre)->exists()) {
                DB::table('tipos_vehiculo')->insert(['nombre' => $nombre]);
            }
        }
    }
}


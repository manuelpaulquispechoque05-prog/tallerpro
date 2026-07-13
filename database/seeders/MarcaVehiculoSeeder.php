<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcaVehiculoSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = [
            'Toyota', 'Honda', 'Suzuki', 'Yamaha', 'Kia',
            'Hyundai', 'Chevrolet', 'Nissan', 'Mazda', 'Mitsubishi',
            'Ford', 'Volkswagen', 'Renault', 'Fiat', 'Peugeot',
            'BMW', 'Mercedes-Benz', 'Audi', 'Jeep', 'Chery',
        ];

        foreach ($marcas as $nombre) {
            DB::table('marcas_vehiculo')->updateOrInsert(
                ['nombre' => $nombre],
                ['nombre' => $nombre]
            );
        }

        $this->command->info('Marcas creadas: ' . count($marcas));
    }
}

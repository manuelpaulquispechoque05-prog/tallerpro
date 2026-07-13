<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModeloVehiculoSeeder extends Seeder
{
    public function run(): void
    {
        $modelos = [
            'Toyota' => ['Corolla', 'Hilux', 'Rav4', 'Yaris', 'Land Cruiser', 'Fortuner', 'Tacoma', 'Camry'],
            'Honda' => ['Civic', 'CR-V', 'HR-V', 'Accord', 'Fit', 'City', 'Pilot', 'Odyssey'],
            'Suzuki' => ['Swift', 'Vitara', 'Jimny', 'Ertiga', 'Baleno', 'Celerio', 'S-Cross', 'Ignis'],
            'Yamaha' => ['FZ', 'YZF-R1', 'MT-07', 'MT-09', 'NMAX', 'XMAX', 'Ténéré 700', 'WR250R'],
            'Kia' => ['Sportage', 'Sorento', 'Cerato', 'Rio', 'Picanto', 'Stonic', 'Seltos', 'K5'],
            'Hyundai' => ['Tucson', 'Santa Fe', 'Elantra', 'Accent', 'Creta', 'Grand i10', 'Sonata', 'Palisade'],
            'Chevrolet' => ['Onix', 'Tracker', 'Cruze', 'Equinox', 'Silverado', 'Camaro', 'Spin', 'Trailblazer'],
            'Nissan' => ['Frontier', 'Sentra', 'Versa', 'Kicks', 'X-Trail', 'Pathfinder', 'March', 'Altima'],
            'Mazda' => ['Mazda3', 'CX-5', 'CX-30', 'Mazda2', 'MX-5', 'CX-9', 'Mazda6', 'BT-50'],
            'Mitsubishi' => ['L200', 'Montero', 'Outlander', 'ASX', 'Mirage', 'Eclipse Cross', 'Pajero', 'Lancer'],
            'Ford' => ['Ranger', 'Mustang', 'Escape', 'Bronco', 'Explorer', 'Territory', 'F-150', 'Focus'],
            'Volkswagen' => ['Gol', 'T-Cross', 'Nivus', 'Taos', 'Amarok', 'Tiguan', 'Jetta', 'Virtus'],
            'Renault' => ['Kwid', 'Sandero', 'Stepway', 'Duster', 'Oroch', 'Logan', 'Koleos', 'Captur'],
            'Fiat' => ['Strada', 'Mobi', 'Uno', 'Argo', 'Cronos', 'Pulse', 'Fastback', 'Toro'],
            'Peugeot' => ['208', '2008', '3008', '5008', 'Partner', 'Expert', 'Landtrek', 'Rifter'],
            'BMW' => ['Serie 3', 'Serie 5', 'X1', 'X3', 'X5', 'Z4', 'M3', 'i4'],
            'Mercedes-Benz' => ['Clase C', 'Clase E', 'GLA', 'GLC', 'GLE', 'Clase A', 'CLA', 'Vito'],
            'Audi' => ['A3', 'A4', 'A6', 'Q3', 'Q5', 'Q7', 'e-tron', 'TT'],
            'Jeep' => ['Wrangler', 'Grand Cherokee', 'Compass', 'Renegade', 'Cherokee', 'Gladiator', 'Wagoneer'],
            'Chery' => ['Tiggo 2', 'Tiggo 3', 'Tiggo 7', 'Tiggo 8', 'Arrizo 5', 'Arrizo 6', 'QQ', 'eQ1'],
        ];

        $marcas = DB::table('marcas_vehiculo')->get()->keyBy('nombre');
        $count = 0;

        foreach ($modelos as $marcaNombre => $lista) {
            $marca = $marcas->get($marcaNombre);
            if (!$marca) continue;

            foreach ($lista as $modeloNombre) {
                DB::table('modelos_vehiculo')->updateOrInsert(
                    ['marca_id' => $marca->id, 'nombre' => $modeloNombre],
                    ['marca_id' => $marca->id, 'nombre' => $modeloNombre]
                );
                $count++;
            }
        }

        $this->command->info('Modelos creados: ' . $count);
    }
}

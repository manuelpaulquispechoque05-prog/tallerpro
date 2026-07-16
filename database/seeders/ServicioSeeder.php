<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'Mantenimiento' => ['Cambio de aceite', 'Cambio de filtros', 'Alineacion', 'Balanceo'],
            'Reparacion' => ['Frenos', 'Suspension', 'Motor', 'Sistema electrico'],
            'Diagnostico' => ['Diagnostico General'],
        ];

        foreach ($tipos as $tipoNombre => $servicios) {
            $tipo = DB::table('tipos_servicio')->where('nombre', $tipoNombre)->first();
            if (!$tipo) {
                $tipoId = DB::table('tipos_servicio')->insertGetId(['nombre' => $tipoNombre]);
            } else {
                $tipoId = $tipo->id;
            }

            $durations = [
                'Cambio de aceite' => 30,
                'Cambio de filtros' => 20,
                'Alineacion' => 40,
                'Balanceo' => 30,
                'Frenos' => 45,
                'Suspension' => 50,
                'Motor' => 120,
                'Sistema electrico' => 40,
                'Diagnostico General' => 60,
            ];

            foreach ($servicios as $s) {
                DB::table('servicios')->updateOrInsert(
                    ['nombre' => $s],
                    [
                        'tipo_servicio_id' => $tipoId,
                        'descripcion' => 'Servicio de ' . $s,
                        'duracion_estimada_min' => $durations[$s] ?? 30,
                        'activo' => true,
                    ]
                );
            }
        }

        $this->command->info('Servicios creados correctamente.');
    }
}

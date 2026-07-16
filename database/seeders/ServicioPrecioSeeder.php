<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioPrecioSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener IDs de servicios por nombre
        $servicios = DB::table('servicios')->pluck('id', 'nombre');
        $tipos = DB::table('tipos_vehiculo')->pluck('id', 'nombre');

        $motoId = $tipos->get('Motocicleta');
        $autoId = $tipos->get('Automovil');
        $camionetaId = $tipos->get('Camioneta');
        $otroId = $tipos->get('Otro');

        if (!$motoId || !$autoId) {
            $this->command->error('Debe existir Motocicleta y Automovil en tipos_vehiculo.');
            return;
        }

        $precios = [
            'Cambio de aceite'    => ['moto' => 40,  'auto' => 80],
            'Cambio de filtros'   => ['moto' => 25,  'auto' => 50],
            'Alineacion'          => ['moto' => 50,  'auto' => 120],
            'Balanceo'            => ['moto' => 40,  'auto' => 80],
            'Frenos'              => ['moto' => 80,  'auto' => 150],
            'Suspension'          => ['moto' => 100, 'auto' => 180],
            'Motor'               => ['moto' => 250, 'auto' => 350],
            'Sistema electrico'   => ['moto' => 80,  'auto' => 120],
            'Diagnostico General' => ['moto' => 60,  'auto' => 100],
        ];

        foreach ($precios as $nombre => $p) {
            $servicioId = $servicios->get($nombre);

            if (!$servicioId) {
                $this->command->warn("Servicio '{$nombre}' no encontrado. Se omite.");
                continue;
            }

            // Moto
            DB::table('servicio_precios')->updateOrInsert(
                ['servicio_id' => $servicioId, 'tipo_vehiculo_id' => $motoId],
                ['precio_base' => $p['moto'], 'created_at' => now(), 'updated_at' => now()]
            );

            // Automovil
            DB::table('servicio_precios')->updateOrInsert(
                ['servicio_id' => $servicioId, 'tipo_vehiculo_id' => $autoId],
                ['precio_base' => $p['auto'], 'created_at' => now(), 'updated_at' => now()]
            );

            // Camioneta y Otro usan mismos precios que Automovil
            if ($camionetaId) {
                DB::table('servicio_precios')->updateOrInsert(
                    ['servicio_id' => $servicioId, 'tipo_vehiculo_id' => $camionetaId],
                    ['precio_base' => $p['auto'], 'created_at' => now(), 'updated_at' => now()]
                );
            }
            if ($otroId) {
                DB::table('servicio_precios')->updateOrInsert(
                    ['servicio_id' => $servicioId, 'tipo_vehiculo_id' => $otroId],
                    ['precio_base' => $p['auto'], 'created_at' => now(), 'updated_at' => now()]
                );
            }
        }

        $this->command->info('Precios por tipo de vehiculo creados correctamente.');
    }
}

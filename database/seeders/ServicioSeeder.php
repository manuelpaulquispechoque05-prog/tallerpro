<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        $tipoDiagnostico = DB::table('tipos_servicio')->where('nombre', 'Diagnostico')->first();
        if (!$tipoDiagnostico) {
            $tipoDiagnosticoId = DB::table('tipos_servicio')->insertGetId([
                'nombre' => 'Diagnostico',
            ]);
        } else {
            $tipoDiagnosticoId = $tipoDiagnostico->id;
        }

        $exists = DB::table('servicios')->where('nombre', 'Diagnostico General')->exists();
        if (!$exists) {
            DB::table('servicios')->insert([
                'tipo_servicio_id' => $tipoDiagnosticoId,
                'nombre' => 'Diagnostico General',
                'descripcion' => 'Revision general del vehiculo para identificar fallas',
                'precio_base' => 0,
                'duracion_estimada_min' => 60,
                'activo' => true,
            ]);
        }
    }
}


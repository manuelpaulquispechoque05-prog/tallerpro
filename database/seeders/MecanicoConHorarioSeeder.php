<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MecanicoConHorarioSeeder extends Seeder
{
    public function run(): void
    {
        // Crear mecanicos de prueba si no existen
        $mecIds = [];
        foreach (['Carlos Mendoza', 'Pedro Vargas', 'Luis Rivera'] as $i => $nombre) {
            $existe = DB::table('mecanicos')->where('nombre', explode(' ', $nombre)[0])->where('apellidos', explode(' ', $nombre)[1])->first();
            if ($existe) {
                $mecIds[] = $existe->id;
            } else {
                $id = DB::table('mecanicos')->insertGetId([
                    'nombre' => explode(' ', $nombre)[0],
                    'apellidos' => explode(' ', $nombre)[1],
                    'especialidad_id' => DB::table('especialidades')->value('id') ?? 1,
                    'sucursal_id' => 1,
                    'fecha_contratacion' => now(),
                    'activo' => true,
                ]);
                $mecIds[] = $id;
            }
        }

        // Horarios Lun-Vie 09:00-20:30 para todos
        foreach ($mecIds as $mecId) {
            for ($dia = 1; $dia <= 5; $dia++) {
                DB::table('horarios_mecanico')->updateOrInsert(
                    ['mecanico_id' => $mecId, 'dia_semana' => $dia],
                    ['hora_inicio' => '09:00', 'hora_fin' => '20:30', 'activo' => true]
                );
            }
        }

        $this->command->info('Mecanicos y horarios creados: ' . count($mecIds));
    }
}

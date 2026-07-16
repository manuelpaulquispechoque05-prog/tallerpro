<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfiguracionSeeder extends Seeder
{
    public function run(): void
    {
        $configs = [
            ['clave' => 'moneda_defecto',       'valor' => 'Bs',   'descripcion' => 'Simbolo de la moneda por defecto del sistema'],
            ['clave' => 'moneda_defecto_codigo', 'valor' => 'BOB', 'descripcion' => 'Codigo ISO de la moneda por defecto'],
            ['clave' => 'moneda_secundaria',     'valor' => 'USD', 'descripcion' => 'Codigo ISO de moneda alternativa para compras'],
            ['clave' => 'moneda_secundaria_simbolo', 'valor' => '$', 'descripcion' => 'Simbolo de la moneda secundaria'],
            ['clave' => 'tipo_cambio_compra',    'valor' => '10.71', 'descripcion' => 'Tipo de cambio usado al registrar compras en USD (1 USD = X Bs)'],
        ];

        foreach ($configs as $c) {
            DB::table('configuraciones')->updateOrInsert(
                ['clave' => $c['clave']],
                ['valor' => $c['valor'], 'descripcion' => $c['descripcion'], 'created_at' => now(), 'updated_at' => now()]
            );
        }

        $this->command->info('Configuraciones creadas correctamente.');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';

    protected $fillable = [
        'tipo_servicio_id', 'nombre', 'descripcion',
        'duracion_estimada_min', 'activo',
    ];

    public function tipoServicio()
    {
        return $this->belongsTo(TipoServicio::class, 'tipo_servicio_id');
    }

    public function precios()
    {
        return $this->hasMany(ServicioPrecio::class);
    }

    /**
     * Obtiene el precio del servicio para un tipo de vehiculo.
     * Si no encuentra precio exacto, busca el precio para Automovil como fallback.
     * Lanza excepcion si tampoco existe precio de Automovil (evita crear ordenes con precio 0).
     */
    public function getPrecio(int $tipoVehiculoId): float
    {
        $precio = $this->precios()
            ->where('tipo_vehiculo_id', $tipoVehiculoId)
            ->value('precio_base');

        if ($precio === null) {
            // Fallback: buscar precio de Automovil (camionetas, otros, etc.)
            static $autoId = null;
            if ($autoId === null) {
                $autoId = \App\Models\TipoVehiculo::where('nombre', 'Automovil')->value('id');
            }
            if ($autoId && $autoId !== $tipoVehiculoId) {
                $precio = $this->precios()
                    ->where('tipo_vehiculo_id', $autoId)
                    ->value('precio_base');
            }
        }

        if ($precio === null) {
            throw new \RuntimeException(
                "El servicio '{$this->nombre}' no tiene un precio configurado para este tipo de vehiculo."
            );
        }

        return (float) $precio;
    }
}

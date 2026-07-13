<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';

    protected $fillable = [
        'cliente_id',
        'tipo_solicitud',
        'servicio_id',
        'descripcion_problema',
        'tipo_vehiculo_id',
        'vehiculo_id',
        'mecanico_id',
        'sucursal_id',
        'orden_trabajo_id',
        'duracion_minutos',
        'fecha_hora',
        'estado',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'duracion_minutos' => 'integer',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function tipoVehiculo()
    {
        return $this->belongsTo(TipoVehiculo::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function mecanico()
    {
        return $this->belongsTo(Mecanico::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function ordenTrabajo()
    {
        return $this->belongsTo(OrdenTrabajo::class);
    }
}

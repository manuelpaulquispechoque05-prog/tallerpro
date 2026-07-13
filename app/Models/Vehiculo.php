<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';

    protected $fillable = [
        'cliente_id', 'marca_id', 'modelo_id', 'anio', 'placa',
        'vin', 'color', 'kilometraje', 'activo',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function marca()
    {
        return $this->belongsTo(MarcaVehiculo::class, 'marca_id');
    }

    public function modelo()
    {
        return $this->belongsTo(ModeloVehiculo::class, 'modelo_id');
    }

    public function ordenesTrabajo()
    {
        return $this->hasMany(OrdenTrabajo::class);
    }
}

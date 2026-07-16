<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioPrecio extends Model
{
    protected $table = 'servicio_precios';

    protected $fillable = [
        'servicio_id', 'tipo_vehiculo_id', 'precio_base',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function tipoVehiculo()
    {
        return $this->belongsTo(TipoVehiculo::class);
    }
}

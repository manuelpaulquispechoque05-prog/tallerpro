<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloVehiculo extends Model
{
    protected $table = 'modelos_vehiculo';

    public $timestamps = false;

    protected $fillable = ['marca_id', 'nombre'];

    public function marca()
    {
        return $this->belongsTo(MarcaVehiculo::class, 'marca_id');
    }

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'modelo_id');
    }
}

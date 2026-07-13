<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarcaVehiculo extends Model
{
    protected $table = 'marcas_vehiculo';

    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function modelos()
    {
        return $this->hasMany(ModeloVehiculo::class, 'marca_id');
    }
}

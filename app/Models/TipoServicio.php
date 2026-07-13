<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    protected $table = 'tipos_servicio';

    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'tipo_servicio_id');
    }
}

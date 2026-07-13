<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';

    protected $fillable = [
        'tipo_servicio_id', 'nombre', 'descripcion',
        'precio_base', 'duracion_estimada_min', 'activo',
    ];

    public function tipoServicio()
    {
        return $this->belongsTo(TipoServicio::class, 'tipo_servicio_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorariosMecanico extends Model
{
    protected $table = 'horarios_mecanico';

    public $timestamps = false;

    protected $fillable = [
        'mecanico_id', 'dia_semana', 'hora_inicio', 'hora_fin', 'activo',
    ];

    public function mecanico()
    {
        return $this->belongsTo(Mecanico::class);
    }
}

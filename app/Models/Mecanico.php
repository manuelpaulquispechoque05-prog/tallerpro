<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mecanico extends Model
{
    use SoftDeletes;

    protected $table = 'mecanicos';

    protected $fillable = [
        'nombre', 'apellidos', 'ci', 'telefono', 'direccion',
        'especialidad_id', 'sucursal_id', 'descripcion', 'observaciones',
        'foto', 'fecha_contratacion', 'activo',
    ];

    protected $casts = ['fecha_contratacion' => 'date'];

    protected $appends = ['nombre_completo'];

    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellidos);
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function ordenesTrabajo()
    {
        return $this->hasMany(OrdenTrabajo::class, 'mecanico_id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'mecanico_id');
    }
}

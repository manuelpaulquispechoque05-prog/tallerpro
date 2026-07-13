<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = 'especialidades';

    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function mecanicos()
    {
        return $this->hasMany(Mecanico::class);
    }
}

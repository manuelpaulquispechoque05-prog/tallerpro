<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaRepuesto extends Model
{
    use SoftDeletes;

    protected $table = 'categorias_repuesto';

    protected $fillable = ['nombre', 'descripcion'];

    public function repuestos()
    {
        return $this->hasMany(Repuesto::class, 'categoria_id');
    }
}

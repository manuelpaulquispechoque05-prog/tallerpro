<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';

    public $timestamps = false;

    protected $fillable = [
        'repuesto_id', 'sucursal_id', 'stock_actual', 'stock_minimo',
    ];

    public function repuesto()
    {
        return $this->belongsTo(Repuesto::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'inventario_id');
    }
}

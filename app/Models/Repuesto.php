<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repuesto extends Model
{
    use SoftDeletes;

    protected $table = 'repuestos';

    protected $fillable = [
        'categoria_id', 'proveedor_id', 'codigo', 'nombre', 'descripcion',
        'precio_compra', 'precio_venta', 'unidad_medida', 'activo',
    ];

    protected $casts = [
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaRepuesto::class, 'categoria_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function inventario()
    {
        return $this->hasOne(Inventario::class);
    }
}

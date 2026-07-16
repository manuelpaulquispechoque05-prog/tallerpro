<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleOrdenRepuesto extends Model
{
    use SoftDeletes;

    protected $table = 'detalle_orden_repuestos';

    public $timestamps = false;

    protected $fillable = [
        'orden_trabajo_id', 'repuesto_id', 'precio_unitario', 'cantidad', 'subtotal',
    ];

    public function orden()
    {
        return $this->belongsTo(OrdenTrabajo::class, 'orden_trabajo_id');
    }

    public function repuesto()
    {
        return $this->belongsTo(Repuesto::class);
    }
}

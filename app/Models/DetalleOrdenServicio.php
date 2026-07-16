<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleOrdenServicio extends Model
{
    use SoftDeletes;

    protected $table = 'detalle_orden_servicios';

    public $timestamps = false;

    protected $fillable = [
        'orden_trabajo_id', 'servicio_id', 'precio_unitario', 'cantidad', 'subtotal',
    ];

    public function orden()
    {
        return $this->belongsTo(OrdenTrabajo::class, 'orden_trabajo_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}

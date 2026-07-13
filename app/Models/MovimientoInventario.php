<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimientoInventario extends Model
{
    use SoftDeletes;

    protected $table = 'movimientos_inventario';

    public $timestamps = false;

    protected $fillable = [
        'inventario_id', 'orden_trabajo_id', 'user_id',
        'tipo', 'cantidad', 'motivo',
    ];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class);
    }

    public function ordenTrabajo()
    {
        return $this->belongsTo(OrdenTrabajo::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

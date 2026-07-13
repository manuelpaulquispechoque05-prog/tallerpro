<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    protected $table = 'ordenes_trabajo';

    protected $fillable = [
        'cliente_id', 'vehiculo_id', 'mecanico_id', 'sucursal_id',
        'creado_por', 'estado', 'kilometraje_ingreso', 'observaciones',
        'total', 'fecha_ingreso', 'fecha_estimada_entrega', 'fecha_entrega',
    ];

    protected $casts = [
        'fecha_ingreso' => 'datetime',
        'fecha_estimada_entrega' => 'datetime',
        'fecha_entrega' => 'datetime',
        'total' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function mecanico()
    {
        return $this->belongsTo(Mecanico::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function detalleServicios()
    {
        return $this->hasMany(DetalleOrdenServicio::class, 'orden_trabajo_id');
    }

    public function detalleRepuestos()
    {
        return $this->hasMany(DetalleOrdenRepuesto::class, 'orden_trabajo_id');
    }
}

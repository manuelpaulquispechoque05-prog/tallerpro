<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\OrdenTrabajo;
use Illuminate\Support\Facades\DB;

class OrdenTrabajoService
{
    public function __construct(
        protected InventarioService $inventarioService
    ) {}

    public function listar(string $busqueda = null, string $estadoFiltro = null, string $ordenarPor = 'created_at', string $direccion = 'desc')
    {
        $columnas = ['id', 'estado', 'total', 'fecha_ingreso', 'created_at'];

        if (!in_array($ordenarPor, $columnas)) {
            $ordenarPor = 'created_at';
        }

        return OrdenTrabajo::with(['cliente', 'vehiculo', 'mecanico'])
            ->when($busqueda, fn($q) => $q->where(function ($q) use ($busqueda) {
                $q->whereHas('cliente', fn($c) => $c->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('apellido', 'like', "%{$busqueda}%"))
                  ->orWhereHas('vehiculo', fn($v) => $v->where('placa', 'like', "%{$busqueda}%"));
            }))
            ->when($estadoFiltro, fn($q) => $q->where('estado', $estadoFiltro))
            ->orderBy($ordenarPor, $direccion === 'asc' ? 'asc' : 'desc')
            ->paginate(10)
            ->withQueryString();
    }

    public function obtenerPorId(int $id): OrdenTrabajo
    {
        return OrdenTrabajo::with(['cliente', 'vehiculo', 'mecanico', 'creador', 'detalleServicios.servicio', 'detalleRepuestos.repuesto'])
            ->findOrFail($id);
    }

    public function crearDesdeCita(int $citaId): OrdenTrabajo
    {
        $cita = Cita::with('cliente', 'vehiculo', 'mecanico', 'servicio')->findOrFail($citaId);

        if ($cita->estado !== 'asignada') {
            throw new \RuntimeException('La cita debe estar asignada para crear una orden.');
        }

        if (!$cita->vehiculo_id) {
            throw new \RuntimeException('Debe registrar un vehiculo antes de crear la orden.');
        }

        $orden = OrdenTrabajo::create([
            'cliente_id' => $cita->cliente_id,
            'vehiculo_id' => $cita->vehiculo_id,
            'mecanico_id' => $cita->mecanico_id,
            'sucursal_id' => $cita->sucursal_id ?? 1,
            'creado_por' => auth()->id(),
            'estado' => 'pendiente',
            'kilometraje_ingreso' => $cita->vehiculo?->kilometraje ?? 0,
            'observaciones' => $cita->descripcion_problema ?? '',
            'total' => 0,
            'fecha_ingreso' => now(),
        ]);

        // Vincular la orden a la cita y marcarla como atendida
        $cita->update([
            'orden_trabajo_id' => $orden->id,
            'estado' => 'atendida',
        ]);

        // Si la cita tiene un servicio especifico, lo agregamos al detalle
        if ($cita->servicio_id) {
            $orden->detalleServicios()->create([
                'servicio_id' => $cita->servicio_id,
                'precio_unitario' => $cita->servicio->precio_base ?? 0,
                'cantidad' => 1,
                'subtotal' => $cita->servicio->precio_base ?? 0,
            ]);

            // Actualizar el total de la orden
            $orden->update(['total' => $cita->servicio->precio_base ?? 0]);
        }

        return $orden;
    }

    // ─── AGREGAR REPUESTO A UNA ORDEN (descuenta stock automaticamente) ───

    public function agregarRepuesto(int $ordenId, int $repuestoId, int $cantidad, float $precioUnitario = null): void
    {
        $orden = OrdenTrabajo::findOrFail($ordenId);

        // Validar que la orden no este completada o cancelada
        if (in_array($orden->estado, ['completado', 'cancelado'])) {
            throw new \RuntimeException('No se pueden agregar repuestos a una orden ' . $orden->estado);
        }

        $repuesto = \App\Models\Repuesto::findOrFail($repuestoId);
        $precio = $precioUnitario ?? $repuesto->precio_venta;
        $subtotal = $precio * $cantidad;

        DB::transaction(function () use ($orden, $repuesto, $cantidad, $precio, $subtotal, $repuestoId) {
            // Descontar stock (lanza excepcion si no hay suficiente)
            $this->inventarioService->registrarSalida(
                $repuestoId,
                $cantidad,
                $orden->id,
                "Consumo en orden de trabajo #{$orden->id} — {$repuesto->nombre}"
            );

            // Registrar en el detalle de la orden
            $orden->detalleRepuestos()->create([
                'repuesto_id' => $repuesto->id,
                'precio_unitario' => $precio,
                'cantidad' => $cantidad,
                'subtotal' => $subtotal,
            ]);

            // Recalcular total de la orden
            $totalServicios = $orden->detalleServicios()->sum('subtotal');
            $totalRepuestos = $orden->detalleRepuestos()->sum('subtotal');
            $orden->update(['total' => $totalServicios + $totalRepuestos]);
        });
    }
}

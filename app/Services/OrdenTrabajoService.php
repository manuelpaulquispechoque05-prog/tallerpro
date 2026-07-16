<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\DetalleOrdenServicio;
use App\Models\OrdenTrabajo;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;

class OrdenTrabajoService
{
    public function __construct(
        protected InventarioService $inventarioService
    ) {}

    public function listar(string $busqueda = null, string $estadoFiltro = null, string $ordenarPor = 'created_at', string $direccion = 'desc')
    {
        $columnas = ['id', 'estado', 'total', 'fecha_ingreso', 'created_at'];
        if (!in_array($ordenarPor, $columnas)) $ordenarPor = 'created_at';

        return OrdenTrabajo::with(['cliente', 'vehiculo', 'mecanico'])
            ->when($busqueda, fn($q) => $q->where(function ($q) use ($busqueda) {
                $q->whereHas('cliente', fn($c) => $c->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('apellido', 'like', "%{$busqueda}%"))
                  ->orWhereHas('vehiculo', fn($v) => $v->where('placa', 'like', "%{$busqueda}%"));
            }))
            ->when($estadoFiltro, fn($q) => $q->where('estado', $estadoFiltro))
            ->orderBy($ordenarPor, $direccion === 'asc' ? 'asc' : 'desc')
            ->paginate(10)->withQueryString();
    }

    public function obtenerPorId(int $id): OrdenTrabajo
    {
        return OrdenTrabajo::with(['cliente', 'vehiculo', 'mecanico', 'creador', 'detalleServicios.servicio', 'detalleRepuestos.repuesto'])
            ->findOrFail($id);
    }

    // ─── CREACION DESDE CITA ──────────────────────────────────────────

    public function crearDesdeCita(int $citaId): OrdenTrabajo
    {
        $cita = Cita::with('cliente', 'vehiculo', 'mecanico', 'servicio')->findOrFail($citaId);

        if ($cita->estado !== 'asignada') throw new \RuntimeException('La cita debe estar asignada.');
        if (!$cita->vehiculo_id) throw new \RuntimeException('Debe registrar un vehiculo.');

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

        Cita::withoutTimestamps(fn() => $cita->update(['orden_trabajo_id' => $orden->id]));

        if ($cita->servicio_id) {
            $precio = $cita->servicio->getPrecio($cita->tipo_vehiculo_id);

            $orden->detalleServicios()->create([
                'servicio_id' => $cita->servicio_id,
                'precio_unitario' => $precio,
                'cantidad' => 1,
                'subtotal' => $precio,
            ]);
        }

        $this->recalcularTotal($orden->id);
        return $orden;
    }

    // ─── SERVICIOS ─────────────────────────────────────────────────────

    public function agregarServicio(int $ordenId, int $servicioId, int $cantidad = 1): void
    {
        $orden = OrdenTrabajo::findOrFail($ordenId);

        if (in_array($orden->estado, ['completado', 'cancelado'])) {
            throw new \RuntimeException('No se pueden modificar servicios en una orden ' . $orden->estado);
        }

        $servicio = Servicio::findOrFail($servicioId);

        // El tipo de vehiculo se obtiene desde la cita que origino la orden
        $tipoVehiculoId = Cita::where('orden_trabajo_id', $ordenId)->value('tipo_vehiculo_id')
            ?? throw new \RuntimeException('No se puede determinar el tipo de vehiculo para esta orden.');

        $precio = $servicio->getPrecio($tipoVehiculoId);
        $subtotal = $precio * $cantidad;

        $orden->detalleServicios()->create([
            'servicio_id' => $servicio->id,
            'precio_unitario' => $precio,
            'cantidad' => $cantidad,
            'subtotal' => $subtotal,
        ]);

        $this->recalcularTotal($ordenId);
    }

    public function quitarServicio(int $detalleId): void
    {
        $detalle = DetalleOrdenServicio::with('orden')->findOrFail($detalleId);
        $orden = $detalle->orden;

        if (in_array($orden->estado, ['completado', 'cancelado'])) {
            throw new \RuntimeException('No se pueden modificar servicios en una orden ' . $orden->estado);
        }

        $detalle->delete();
        $this->recalcularTotal($orden->id);
    }

    // ─── REPUESTOS ─────────────────────────────────────────────────────

    public function agregarRepuesto(int $ordenId, int $repuestoId, int $cantidad, float $precioUnitario = null): void
    {
        $orden = OrdenTrabajo::findOrFail($ordenId);

        if (in_array($orden->estado, ['completado', 'cancelado'])) {
            throw new \RuntimeException('No se pueden agregar repuestos a una orden ' . $orden->estado);
        }

        $repuesto = \App\Models\Repuesto::findOrFail($repuestoId);
        $precio = $precioUnitario ?? $repuesto->precio_venta;
        $subtotal = $precio * $cantidad;

        DB::transaction(function () use ($orden, $repuesto, $cantidad, $precio, $subtotal, $repuestoId) {
            $this->inventarioService->registrarSalida(
                $repuestoId, $cantidad, $orden->id, $orden->sucursal_id,
                "Consumo en orden #{$orden->id} — {$repuesto->nombre}"
            );

            $orden->detalleRepuestos()->create([
                'repuesto_id' => $repuesto->id,
                'precio_unitario' => $precio,
                'cantidad' => $cantidad,
                'subtotal' => $subtotal,
            ]);

            $this->recalcularTotal($orden->id);
        });
    }

    public function quitarRepuesto(int $detalleId): void
    {
        $detalle = \App\Models\DetalleOrdenRepuesto::with('orden')->findOrFail($detalleId);
        $orden = $detalle->orden;

        if (in_array($orden->estado, ['completado', 'cancelado'])) {
            throw new \RuntimeException('No se pueden modificar repuestos en una orden ' . $orden->estado);
        }

        $detalle->delete();
        $this->recalcularTotal($orden->id);
    }

    // ─── CAMBIOS DE ESTADO ─────────────────────────────────────────────

    public function iniciar(int $ordenId): void
    {
        $orden = OrdenTrabajo::findOrFail($ordenId);

        if ($orden->estado !== 'pendiente') {
            throw new \RuntimeException('Solo se puede iniciar una orden en estado pendiente.');
        }

        $orden->update([
            'estado' => 'en_proceso',
            'fecha_ingreso' => $orden->fecha_ingreso ?? now(),
        ]);
    }

    public function completar(int $ordenId): void
    {
        $orden = OrdenTrabajo::findOrFail($ordenId);

        if ($orden->estado !== 'en_proceso') {
            throw new \RuntimeException('Solo se puede completar una orden en proceso.');
        }

        $orden->update([
            'estado' => 'completado',
            'fecha_entrega' => now(),
        ]);
    }

    public function cancelar(int $ordenId): void
    {
        $orden = OrdenTrabajo::findOrFail($ordenId);

        if (in_array($orden->estado, ['completado', 'cancelado'])) {
            throw new \RuntimeException('La orden ya esta ' . $orden->estado);
        }

        $orden->update(['estado' => 'cancelado']);
    }

    // ─── RECALCULO ─────────────────────────────────────────────────────

    private function recalcularTotal(int $ordenId): void
    {
        $orden = OrdenTrabajo::findOrFail($ordenId);
        $totalServicios = $orden->detalleServicios()->sum('subtotal');
        $totalRepuestos = $orden->detalleRepuestos()->sum('subtotal');
        $orden->update(['total' => $totalServicios + $totalRepuestos]);
    }
}

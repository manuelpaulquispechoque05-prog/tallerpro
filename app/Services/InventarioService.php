<?php

namespace App\Services;

use App\Models\Inventario;
use App\Models\MovimientoInventario;
use App\Models\Repuesto;
use Illuminate\Support\Facades\DB;

class InventarioService
{
    public function listar(string $busqueda = null)
    {
        return Inventario::with(['repuesto.categoria', 'repuesto.proveedor', 'sucursal'])
            ->when($busqueda, fn($q) => $q->whereHas('repuesto', fn($r) => $r->where('nombre', 'like', "%{$busqueda}%")
                ->orWhere('codigo', 'like', "%{$busqueda}%")))
            ->orderByRaw('(stock_actual - stock_minimo) ASC')
            ->paginate(15)
            ->withQueryString();
    }

    public function alertasStock(): array
    {
        $items = Inventario::with(['repuesto', 'sucursal'])
            ->whereColumn('stock_actual', '<=', 'stock_minimo')
            ->orderByRaw('(stock_actual - stock_minimo) ASC')
            ->get();

        return [
            'agotados' => $items->filter(fn($i) => $i->stock_actual <= 0)->values(),
            'bajos' => $items->filter(fn($i) => $i->stock_actual > 0)->values(),
            'total' => $items,
        ];
    }

    public function registrarIngreso(array $data): MovimientoInventario
    {
        return DB::transaction(function () use ($data) {
            $repuesto = Repuesto::findOrFail($data['repuesto_id']);

            $inventario = Inventario::firstOrCreate(
                ['repuesto_id' => $repuesto->id, 'sucursal_id' => $data['sucursal_id'] ?? 1],
                ['stock_actual' => 0, 'stock_minimo' => 5]
            );

            $inventario->increment('stock_actual', $data['cantidad']);

            $motivo = 'Ingreso por compra';
            if (!empty($data['numero_factura'])) {
                $motivo .= ' — Factura: ' . $data['numero_factura'];
            }
            if (!empty($data['observaciones'])) {
                $motivo .= ' — ' . $data['observaciones'];
            }

            return MovimientoInventario::create([
                'inventario_id' => $inventario->id,
                'orden_trabajo_id' => null,
                'user_id' => auth()->id(),
                'tipo' => 'entrada',
                'cantidad' => $data['cantidad'],
                'motivo' => $motivo,
            ]);
        });
    }

    public function registrarSalida(int $repuestoId, int $cantidad, int $ordenTrabajoId, string $motivo = null): MovimientoInventario
    {
        return DB::transaction(function () use ($repuestoId, $cantidad, $ordenTrabajoId, $motivo) {
            $inventario = Inventario::where('repuesto_id', $repuestoId)->first();

            if (!$inventario || $inventario->stock_actual < $cantidad) {
                $disponible = $inventario?->stock_actual ?? 0;
                throw new \RuntimeException(
                    "Stock insuficiente. Disponible: {$disponible}, solicitado: {$cantidad}."
                );
            }

            $inventario->decrement('stock_actual', $cantidad);

            return MovimientoInventario::create([
                'inventario_id' => $inventario->id,
                'orden_trabajo_id' => $ordenTrabajoId,
                'user_id' => auth()->id(),
                'tipo' => 'salida',
                'cantidad' => $cantidad,
                'motivo' => $motivo ?? 'Consumo en orden #' . $ordenTrabajoId,
            ]);
        });
    }

    public function movimientos(int $inventarioId = null, int $limit = 20)
    {
        return MovimientoInventario::with(['inventario.repuesto.categoria', 'usuario', 'ordenTrabajo'])
            ->when($inventarioId, fn($q) => $q->where('inventario_id', $inventarioId))
            ->latest('created_at')
            ->take($limit)
            ->get();
    }

    public function movimientosPorRepuesto(int $repuestoId, int $limit = 50)
    {
        return MovimientoInventario::with(['inventario.repuesto', 'usuario', 'ordenTrabajo'])
            ->whereHas('inventario', fn($q) => $q->where('repuesto_id', $repuestoId))
            ->latest('created_at')
            ->take($limit)
            ->get();
    }

    public function repuestosParaIngreso()
    {
        return Repuesto::orderBy('nombre')->get(['id', 'nombre', 'codigo']);
    }

    public function verificarStock(int $repuestoId, int $cantidad): bool
    {
        $inventario = Inventario::where('repuesto_id', $repuestoId)->first();
        return $inventario && $inventario->stock_actual >= $cantidad;
    }

    public function kpis(): array
    {
        $totalRepuestos = Repuesto::where('activo', true)->count();
        $valorTotal = Inventario::join('repuestos', 'inventario.repuesto_id', '=', 'repuestos.id')
            ->selectRaw('SUM(inventario.stock_actual * repuestos.precio_compra) as total')
            ->value('total') ?? 0;

        $alertas = $this->alertasStock();

        return [
            'total_repuestos' => $totalRepuestos,
            'valor_inventario' => $valorTotal,
            'stock_bajo' => $alertas['bajos']->count(),
            'stock_agotado' => $alertas['agotados']->count(),
        ];
    }
}

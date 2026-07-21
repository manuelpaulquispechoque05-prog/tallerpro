<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\OrdenTrabajo;
use App\Models\Vehiculo;

class DashboardService
{
    public function __construct(
        protected InventarioService $inventarioService,
        protected MecanicoService $mecanicoService
    ) {}

    public function kpis(): array
    {
        $inv = $this->inventarioService->kpis();
        $mec = $this->mecanicoService->kpis();

        return [
            'clientes_registrados' => Cliente::where('activo', true)->count(),
            'vehiculos_registrados' => Vehiculo::where('activo', true)->count(),
            'citas_pendientes' => Cita::where('estado', 'pendiente')->count(),
            'ordenes_completadas' => OrdenTrabajo::where('estado', 'completado')->count(),
            'ingresos_mes' => OrdenTrabajo::where('estado', 'completado')
                ->whereMonth('fecha_entrega', now()->month)
                ->whereYear('fecha_entrega', now()->year)
                ->sum('total'),
            'total_repuestos' => $inv['total_repuestos'],
            'total_mecanicos' => $mec['total_mecanicos'],
            'mecanicos_disponibles' => $mec['mecanicos_disponibles'],
            'stock_bajo' => $inv['stock_bajo'],
            'stock_agotado' => $inv['stock_agotado'],
        ];
    }

    public function citasPorEstado(): array
    {
        $data = Cita::selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();

        $labels = [
            'pendiente' => 'Pendiente',
            'confirmada' => 'Confirmada',
            'asignada' => 'Asignada',
            'completada' => 'Completada',
            'cancelada' => 'Cancelada',
        ];
        $colors = [
            'pendiente' => '#eab308',
            'confirmada' => '#3b82f6',
            'asignada' => '#8b5cf6',
            'completada' => '#22c55e',
            'cancelada' => '#6b7280',
        ];

        $series = [];
        $cats = [];
        $cols = [];

        foreach ($labels as $key => $label) {
            $cats[] = $label;
            $series[] = (int) ($data[$key] ?? 0);
            $cols[] = $colors[$key];
        }

        return ['series' => $series, 'labels' => $cats, 'colors' => $cols];
    }

    public function ordenesPorMes(): array
    {
        $meses = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $meses->push([
                'label' => $date->isoFormat('MMM'),
                'year' => $date->year,
                'month' => $date->month,
            ]);
        }

        $data = OrdenTrabajo::where('estado', 'completado')
            ->whereBetween('fecha_entrega', [now()->subMonths(6)->startOfMonth(), now()->endOfMonth()])
            ->selectRaw('YEAR(fecha_entrega) as anio, MONTH(fecha_entrega) as mes, count(*) as total')
            ->groupBy('anio', 'mes')
            ->get()
            ->keyBy(fn($item) => $item->anio . '-' . $item->mes);

        $categories = [];
        $values = [];

        foreach ($meses as $m) {
            $categories[] = $m['label'];
            $key = $m['year'] . '-' . $m['month'];
            $values[] = (int) ($data[$key]->total ?? 0);
        }

        return ['categories' => $categories, 'values' => $values];
    }

    public function ultimasCitas(int $limit = 6)
    {
        return Cita::with(['cliente', 'servicio', 'tipoVehiculo', 'mecanico'])
            ->latest('fecha_hora')
            ->take($limit)
            ->get();
    }
}

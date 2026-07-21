<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index()
    {
        $kpis = $this->dashboardService->kpis();
        $donut = $this->dashboardService->citasPorEstado();
        $line = $this->dashboardService->ordenesPorMes();
        $ultimasCitas = $this->dashboardService->ultimasCitas();

        return view('panel.dashboard.index', compact(
            'kpis', 'donut', 'line', 'ultimasCitas'
        ));
    }
}

@extends('layouts.panel')
@section('title', 'Dashboard')

@section('content')
<!-- KPIs -->
<div class="grid grid-cols-2 lg:grid-cols-5 gap-3 lg:gap-4 mb-6">
    @php
        $kpiData = [
            ['label' => 'Clientes registrados', 'value' => $kpis['clientes_registrados'], 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'color' => 'green'],
            ['label' => 'Vehiculos registrados', 'value' => $kpis['vehiculos_registrados'], 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => 'purple'],
            ['label' => 'Citas pendientes', 'value' => $kpis['citas_pendientes'], 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'yellow'],
            ['label' => 'Repuestos', 'value' => $kpis['total_repuestos'], 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'color' => 'blue'],
            ['label' => 'Stock bajo', 'value' => $kpis['stock_bajo'] + $kpis['stock_agotado'], 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.054 0 1.632-1.159.9-2l-6.929-6.858c-.494-.49-1.306-.49-1.8 0L3.162 17c-.732.841.154 2.1.9 2.1z', 'color' => 'red'],
        ];
        $gradMap = [
            'green' => ['from' => 'from-green-500/20', 'to' => 'to-green-600/10', 'text' => 'text-green-400'],
            'purple' => ['from' => 'from-purple-500/20', 'to' => 'to-purple-600/10', 'text' => 'text-purple-400'],
            'yellow' => ['from' => 'from-yellow-500/20', 'to' => 'to-yellow-600/10', 'text' => 'text-yellow-400'],
            'blue' => ['from' => 'from-blue-500/20', 'to' => 'to-blue-600/10', 'text' => 'text-blue-400'],
            'red' => ['from' => 'from-red-500/20', 'to' => 'to-red-600/10', 'text' => 'text-red-400'],
        ];
    @endphp

    @foreach($kpiData as $i => $k)
        @php $g = $gradMap[$k['color']]; @endphp
        <div class="animate-in animate-in-d{{ $i + 1 }} glass-card rounded-2xl p-4 lg:p-5 hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ $g['from'] }} {{ $g['to'] }} flex items-center justify-center">
                    <svg class="w-5 h-5 {{ $g['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $k['icon'] }}"/></svg>
                </div>
            </div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $k['label'] }}</p>
            <p class="mt-1 text-2xl lg:text-3xl font-bold text-white tracking-tight">{{ $k['value'] }}</p>
        </div>
    @endforeach
</div>

<!-- Charts -->
<div class="grid lg:grid-cols-2 gap-4 mb-6">
    <div class="animate-in animate-in-d5 glass-card rounded-2xl p-5 lg:p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-100">Citas por estado</h3>
                <p class="text-xs text-gray-500 mt-0.5">Distribucion actual</p>
            </div>
            <span class="text-xs text-gray-600 bg-white/[0.04] px-2.5 py-1 rounded-full">Hoy</span>
        </div>
        <div id="donutChart" style="height: 260px;"></div>
    </div>

    <div class="animate-in animate-in-d6 glass-card rounded-2xl p-5 lg:p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-100">Citas atendidas</h3>
                <p class="text-xs text-gray-500 mt-0.5">Ultimos 6 meses</p>
            </div>
            <span class="text-xs text-gray-600 bg-white/[0.04] px-2.5 py-1 rounded-full">{{ now()->year }}</span>
        </div>
        <div id="lineChart" style="height: 260px;"></div>
    </div>
</div>

<!-- Table -->
<div class="animate-in animate-in-d6 glass-card rounded-2xl overflow-hidden">
    <div class="px-5 lg:px-6 py-4 border-b border-white/[0.06] flex items-center justify-between">
        <div>
            <h3 class="text-sm font-semibold text-gray-100">Ultimas citas</h3>
            <p class="text-xs text-gray-500 mt-0.5">Actividad reciente del taller</p>
        </div>
        <a href="{{ route('panel.citas.index') }}" class="text-xs font-medium text-blue-400 hover:text-blue-300 transition">Ver todas</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/[0.04]">
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">#</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Cliente</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Servicio</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Vehiculo</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Estado</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-semibold uppercase tracking-wider text-gray-600">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $colorEstado = [
                        'pendiente' => ['label' => 'Pendiente', 'dot' => 'bg-yellow-400', 'bg' => 'bg-yellow-500/10', 'text' => 'text-yellow-400'],
                        'confirmada' => ['label' => 'Confirmada', 'dot' => 'bg-blue-400', 'bg' => 'bg-blue-500/10', 'text' => 'text-blue-400'],
                        'asignada' => ['label' => 'Asignada', 'dot' => 'bg-purple-400', 'bg' => 'bg-purple-500/10', 'text' => 'text-purple-400'],
                        'atendida' => ['label' => 'Atendida', 'dot' => 'bg-green-400', 'bg' => 'bg-green-500/10', 'text' => 'text-green-400'],
                        'cancelada' => ['label' => 'Cancelada', 'dot' => 'bg-gray-400', 'bg' => 'bg-gray-500/10', 'text' => 'text-gray-400'],
                    ];
                @endphp
                @forelse($ultimasCitas as $c)
                    @php $e = $colorEstado[$c->estado] ?? $colorEstado['pendiente']; @endphp
                    <tr class="border-b border-white/[0.03] hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-3.5 font-medium text-gray-300">#{{ $c->id }}</td>
                        <td class="px-5 py-3.5 text-gray-400">{{ $c->cliente?->nombre_completo ?? '—' }}</td>
                        <td class="px-5 py-3.5 text-sm text-gray-400">{{ $c->servicio?->nombre ?? 'Diagnostico' }}</td>
                        <td class="px-5 py-3.5 text-sm text-gray-500">{{ $c->tipoVehiculo?->nombre ?? '—' }}</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $e['bg'] }} {{ $e['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $e['dot'] }}"></span>
                                {{ $e['label'] }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-xs text-gray-600">{{ $c->fecha_hora?->format('d/m') ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-sm text-gray-500">Sin registros</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const textColor = '#94a3b8';
    const gridColor = 'rgba(255,255,255,0.04)';

    new ApexCharts(document.querySelector('#donutChart'), {
        series: @json($donut['series']),
        chart: { type: 'donut', height: 260, background: 'transparent' },
        labels: @json($donut['labels']),
        colors: @json($donut['colors']),
        stroke: { show: false },
        dataLabels: { enabled: false },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        name: { show: true, fontSize: '13px', color: textColor, offsetY: -5 },
                        total: { show: true, label: 'Total', fontSize: '14px', color: textColor, formatter: () => @json(array_sum($donut['series'])) },
                        value: { show: true, fontSize: '24px', fontWeight: 700, color: '#f8fafc', formatter: (v) => v }
                    }
                }
            }
        },
        legend: { position: 'bottom', labels: { colors: textColor }, markers: { radius: 3, strokeWidth: 0 }, itemMargin: { horizontal: 14 } },
        tooltip: { theme: 'dark' },
    }).render();

    new ApexCharts(document.querySelector('#lineChart'), {
        series: [{ name: 'Atendidas', data: @json($line['values']) }],
        chart: { type: 'area', height: 260, background: 'transparent', toolbar: { show: false }, zoom: { enabled: false } },
        colors: ['#3b82f6'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.25, opacityTo: 0, stops: [0, 90, 100] } },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: {
            categories: @json($line['categories']),
            labels: { style: { colors: textColor, fontSize: '11px' } },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: { labels: { style: { colors: textColor, fontSize: '11px' } }, min: 0 },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        dataLabels: { enabled: false },
        tooltip: { theme: 'dark' },
        markers: { size: 5, colors: ['#3b82f6'], strokeColors: '#1e293b', strokeWidth: 2, hover: { size: 7 } }
    }).render();
});
</script>
@endsection

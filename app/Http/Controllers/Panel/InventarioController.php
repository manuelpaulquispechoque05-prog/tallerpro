<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\ConfiguracionService;
use App\Services\InventarioService;
use App\Services\RepuestoService;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function __construct(
        protected InventarioService $inventarioService,
        protected RepuestoService $repuestoService,
        protected ConfiguracionService $configuracionService,
    ) {}

    public function index(Request $request)
    {
        $busqueda = $request->get('busqueda');
        $filtros = $request->only(['desde', 'hasta', 'mes', 'anio']);
        $items = $this->inventarioService->listar($busqueda, $filtros);
        $alertas = $this->inventarioService->alertasStock();
        return view('panel.inventario.index', compact('items', 'busqueda', 'alertas'));
    }

    public function ingreso()
    {
        $repuestos = $this->inventarioService->repuestosParaIngreso();
        $sucursales = \App\Models\Sucursal::where('activo', true)->orderBy('nombre')->get();
        $tipoCambio = $this->configuracionService->getTipoCambio();
        return view('panel.inventario.ingreso', compact('repuestos', 'sucursales', 'tipoCambio'));
    }

    public function storeIngreso(Request $request)
    {
        $validated = $request->validate([
            'repuesto_id' => 'required|exists:repuestos,id',
            'cantidad' => 'required|integer|min:1',
            'numero_factura' => 'nullable|string|max:50',
            'observaciones' => 'nullable|string|max:255',
            'sucursal_id' => 'nullable|exists:sucursales,id',
            'precio_unitario' => 'nullable|numeric|min:0',
            'moneda' => 'nullable|in:Bs,USD',
        ]);

        try {
            $this->inventarioService->registrarIngreso($validated);
            return redirect()->route('panel.inventario.index')
                ->with('success', 'Ingreso registrado. Stock actualizado.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function historial(int $repuestoId)
    {
        $repuesto = $this->repuestoService->obtenerPorId($repuestoId);
        $movimientos = $this->inventarioService->movimientosPorRepuesto($repuestoId);
        return view('panel.inventario.historial', compact('repuesto', 'movimientos'));
    }

    public function movimientos(Request $request)
    {
        $filtros = $request->only(['desde', 'hasta', 'mes', 'anio']);
        $movimientos = $this->inventarioService->movimientos(null, $filtros);
        return view('panel.inventario.movimientos', compact('movimientos'));
    }
}

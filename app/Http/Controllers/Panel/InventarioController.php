<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\InventarioService;
use App\Services\RepuestoService;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function __construct(
        protected InventarioService $inventarioService,
        protected RepuestoService $repuestoService
    ) {}

    public function index(Request $request)
    {
        $busqueda = $request->get('busqueda');
        $items = $this->inventarioService->listar($busqueda);
        $alertas = $this->inventarioService->alertasStock();
        return view('panel.inventario.index', compact('items', 'busqueda', 'alertas'));
    }

    public function ingreso()
    {
        $repuestos = $this->inventarioService->repuestosParaIngreso();
        $sucursales = \App\Models\Sucursal::where('activo', true)->orderBy('nombre')->get();
        return view('panel.inventario.ingreso', compact('repuestos', 'sucursales'));
    }

    public function storeIngreso(Request $request)
    {
        $validated = $request->validate([
            'repuesto_id' => 'required|exists:repuestos,id',
            'cantidad' => 'required|integer|min:1',
            'numero_factura' => 'nullable|string|max:50',
            'observaciones' => 'nullable|string|max:255',
            'sucursal_id' => 'nullable|exists:sucursales,id',
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

    public function movimientos()
    {
        $movimientos = $this->inventarioService->movimientos();
        return view('panel.inventario.movimientos', compact('movimientos'));
    }
}

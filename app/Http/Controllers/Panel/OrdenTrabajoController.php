<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Repuesto;
use App\Models\Servicio;
use App\Services\OrdenTrabajoService;
use Illuminate\Http\Request;

class OrdenTrabajoController extends Controller
{
    public function __construct(
        protected OrdenTrabajoService $ordenTrabajoService
    ) {}

    public function index(Request $request)
    {
        return view('panel.ordenes.index', [
            'ordenes' => $this->ordenTrabajoService->listar(
                $request->get('busqueda'),
                $request->get('estado'),
                $request->get('ordenar_por', 'created_at'),
                $request->get('direccion', 'desc')
            ),
            'busqueda' => $request->get('busqueda'),
            'estadoFiltro' => $request->get('estado'),
            'ordenarPor' => $request->get('ordenar_por', 'created_at'),
            'direccion' => $request->get('direccion', 'desc'),
        ]);
    }

    public function show(int $id)
    {
        $orden = $this->ordenTrabajoService->obtenerPorId($id);
        $servicios = Servicio::where('activo', true)->orderBy('nombre')->get();
        $repuestos = Repuesto::where('activo', true)->orderBy('nombre')->get();
        return view('panel.ordenes.show', compact('orden', 'servicios', 'repuestos'));
    }

    public function crearDesdeCita(int $citaId)
    {
        try {
            $orden = $this->ordenTrabajoService->crearDesdeCita($citaId);
            return redirect()->route('panel.ordenes.show', $orden->id)->with('success', 'Orden #' . $orden->id . ' creada.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function agregarServicio(Request $request, int $id)
    {
        $v = $request->validate(['servicio_id' => 'required|exists:servicios,id', 'cantidad' => 'nullable|integer|min:1']);
        try {
            $this->ordenTrabajoService->agregarServicio($id, $v['servicio_id'], $v['cantidad'] ?? 1);
            return redirect()->route('panel.ordenes.show', $id)->with('success', 'Servicio agregado.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function quitarServicio(int $id, int $detalleId)
    {
        try {
            $this->ordenTrabajoService->quitarServicio($detalleId);
            return redirect()->route('panel.ordenes.show', $id)->with('success', 'Servicio eliminado.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function agregarRepuesto(Request $request, int $id)
    {
        $v = $request->validate([
            'repuesto_id' => 'required|exists:repuestos,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'nullable|numeric|min:0',
        ]);
        try {
            $this->ordenTrabajoService->agregarRepuesto($id, $v['repuesto_id'], $v['cantidad'], $v['precio_unitario'] ?? null);
            return redirect()->route('panel.ordenes.show', $id)->with('success', 'Repuesto agregado.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function quitarRepuesto(int $id, int $detalleId)
    {
        try {
            $this->ordenTrabajoService->quitarRepuesto($detalleId);
            return redirect()->route('panel.ordenes.show', $id)->with('success', 'Repuesto eliminado.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function iniciar(int $id)
    {
        try {
            $this->ordenTrabajoService->iniciar($id);
            return redirect()->route('panel.ordenes.show', $id)->with('success', 'Orden iniciada.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function completar(int $id)
    {
        try {
            $this->ordenTrabajoService->completar($id);
            return redirect()->route('panel.ordenes.show', $id)->with('success', 'Orden completada.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cancelar(int $id)
    {
        try {
            $this->ordenTrabajoService->cancelar($id);
            return redirect()->route('panel.ordenes.index')->with('success', 'Orden cancelada.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

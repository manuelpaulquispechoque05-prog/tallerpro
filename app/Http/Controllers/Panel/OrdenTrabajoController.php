<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\OrdenTrabajoService;
use Illuminate\Http\Request;

class OrdenTrabajoController extends Controller
{
    public function __construct(
        protected OrdenTrabajoService $ordenTrabajoService
    ) {}

    public function index(Request $request)
    {
        $busqueda = $request->get('busqueda');
        $estadoFiltro = $request->get('estado');
        $ordenarPor = $request->get('ordenar_por', 'created_at');
        $direccion = $request->get('direccion', 'desc');

        $ordenes = $this->ordenTrabajoService->listar($busqueda, $estadoFiltro, $ordenarPor, $direccion);

        return view('panel.ordenes.index', compact('ordenes', 'busqueda', 'estadoFiltro', 'ordenarPor', 'direccion'));
    }

    public function show(int $id)
    {
        $orden = $this->ordenTrabajoService->obtenerPorId($id);
        return view('panel.ordenes.show', compact('orden'));
    }

    public function crearDesdeCita(int $citaId)
    {
        try {
            $orden = $this->ordenTrabajoService->crearDesdeCita($citaId);
            return redirect()->route('panel.ordenes.show', $orden->id)
                ->with('success', 'Orden de trabajo #' . $orden->id . ' creada correctamente.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

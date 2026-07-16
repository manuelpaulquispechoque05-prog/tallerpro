<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\CitaService;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function __construct(
        protected CitaService $citaService,
    ) {}

    public function index(Request $request)
    {
        $busqueda = $request->get('busqueda');
        $estadoFiltro = $request->get('estado');
        $ordenarPor = $request->get('ordenar_por', 'fecha_hora');
        $direccion = $request->get('direccion', 'asc');

        $citas = $this->citaService->listar($busqueda, $estadoFiltro, $ordenarPor, $direccion);

        return view('panel.citas.index', compact('citas', 'busqueda', 'estadoFiltro', 'ordenarPor', 'direccion'));
    }

    public function show(int $id)
    {
        $cita = $this->citaService->obtenerPorId($id);
        $mecanicos = $this->citaService->obtenerMecanicosDisponibles($cita);

        return view('panel.citas.show', compact('cita', 'mecanicos'));
    }

    public function confirmar(int $id)
    {
        try {
            $this->citaService->confirmar($id);
            return redirect()->route('panel.citas.index')
                ->with('success', 'Cita confirmada correctamente.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function asignarMecanico(Request $request, int $id)
    {
        $request->validate(['mecanico_id' => 'required|exists:mecanicos,id']);

        try {
            $this->citaService->asignarMecanico($id, $request->mecanico_id);
            return redirect()->route('panel.citas.index')
                ->with('success', 'Mecanico asignado correctamente.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cancelar(int $id)
    {
        try {
            $this->citaService->cancelar($id);
            return redirect()->route('panel.citas.index')
                ->with('success', 'Cita cancelada correctamente.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

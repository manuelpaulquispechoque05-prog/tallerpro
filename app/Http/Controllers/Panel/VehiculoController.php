<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\StoreVehiculoRequest;
use App\Http\Requests\Panel\UpdateVehiculoRequest;
use App\Services\VehiculoService;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function __construct(
        protected VehiculoService $vehiculoService
    ) {}

    public function index(Request $request)
    {
        $busqueda = $request->get('busqueda');
        $ordenarPor = $request->get('ordenar_por', 'created_at');
        $direccion = $request->get('direccion', 'desc');

        $vehiculos = $this->vehiculoService->listar($busqueda, $ordenarPor, $direccion);

        return view('panel.vehiculos.index', compact('vehiculos', 'busqueda', 'ordenarPor', 'direccion'));
    }

    public function create(Request $request)
    {
        $marcas = $this->vehiculoService->obtenerMarcas();
        $clienteId = $request->get('cliente_id');
        $citaId = $request->get('cita_id');

        $clienteNombre = null;
        $citaInfo = null;

        if ($clienteId) {
            $cliente = \App\Models\Cliente::find($clienteId);
            $clienteNombre = $cliente?->nombre_completo;
        }

        if ($citaId) {
            $citaInfo = \App\Models\Cita::with('tipoVehiculo', 'cliente')->find($citaId);
        }

        return view('panel.vehiculos.create', compact('marcas', 'clienteId', 'citaId', 'clienteNombre', 'citaInfo'));
    }

    public function store(StoreVehiculoRequest $request)
    {
        $vehiculo = $this->vehiculoService->crear($request->validated());

        // Si viene de una cita, asociamos el vehiculo y redirigimos de vuelta
        if ($citaId = $request->get('cita_id')) {
            \App\Models\Cita::where('id', $citaId)->update(['vehiculo_id' => $vehiculo->id]);
            return redirect()->route('panel.citas.show', $citaId)
                ->with('success', 'Vehiculo registrado y asociado a la cita correctamente.');
        }

        return redirect()->route('panel.vehiculos.index')
            ->with('success', 'Vehiculo registrado correctamente.');
    }

    public function show(int $id)
    {
        $vehiculo = $this->vehiculoService->obtenerPorId($id);
        return view('panel.vehiculos.show', compact('vehiculo'));
    }

    public function edit(int $id)
    {
        $vehiculo = $this->vehiculoService->obtenerPorId($id);
        $marcas = $this->vehiculoService->obtenerMarcas();
        return view('panel.vehiculos.edit', compact('vehiculo', 'marcas'));
    }

    public function update(UpdateVehiculoRequest $request, int $id)
    {
        $this->vehiculoService->actualizar($id, $request->validated());

        return redirect()->route('panel.vehiculos.index')
            ->with('success', 'Vehiculo actualizado correctamente.');
    }

    public function destroy(int $id)
    {
        $this->vehiculoService->eliminar($id);

        return redirect()->route('panel.vehiculos.index')
            ->with('success', 'Vehiculo eliminado correctamente.');
    }

    // ─── Endpoints JSON ──────────────────────────────────────────────

    public function modelosPorMarca(int $marcaId)
    {
        return response()->json(
            $this->vehiculoService->obtenerModelosPorMarca($marcaId)
        );
    }

    public function buscarClientes(Request $request)
    {
        $term = $request->get('q', '');

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        return response()->json(
            $this->vehiculoService->buscarClientes($term)
        );
    }
}

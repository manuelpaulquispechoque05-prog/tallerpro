<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\StoreRepuestoRequest;
use App\Http\Requests\Panel\UpdateRepuestoRequest;
use App\Services\ConfiguracionService;
use App\Services\RepuestoService;
use Illuminate\Http\Request;

class RepuestoController extends Controller
{
    public function __construct(
        protected RepuestoService $repuestoService,
        protected ConfiguracionService $configuracionService,
    ) {}

    public function index(Request $request)
    {
        $busqueda = $request->get('busqueda');
        $filtros = $request->only(['desde', 'hasta', 'mes', 'anio']);
        $repuestos = $this->repuestoService->listar($busqueda, $filtros);

        return view('panel.repuestos.index', compact('repuestos', 'busqueda'));
    }

    public function create()
    {
        $categorias = $this->repuestoService->listarCategorias();
        $proveedores = $this->repuestoService->listarProveedores();
        $tipoCambio = $this->configuracionService->getTipoCambio();
        return view('panel.repuestos.create', compact('categorias', 'proveedores', 'tipoCambio'));
    }

    public function store(StoreRepuestoRequest $request)
    {
        $this->repuestoService->crear($request->validated());

        return redirect()->route('panel.repuestos.index')
            ->with('success', 'Repuesto registrado correctamente.');
    }

    public function show(int $id)
    {
        $repuesto = $this->repuestoService->obtenerPorId($id);
        return view('panel.repuestos.show', compact('repuesto'));
    }

    public function edit(int $id)
    {
        $repuesto = $this->repuestoService->obtenerPorId($id);
        $categorias = $this->repuestoService->listarCategorias();
        $proveedores = $this->repuestoService->listarProveedores();
        $tipoCambio = $this->configuracionService->getTipoCambio();
        return view('panel.repuestos.edit', compact('repuesto', 'categorias', 'proveedores', 'tipoCambio'));
    }

    public function update(UpdateRepuestoRequest $request, int $id)
    {
        $this->repuestoService->actualizar($id, $request->validated());

        return redirect()->route('panel.repuestos.index')
            ->with('success', 'Repuesto actualizado correctamente.');
    }

    public function destroy(int $id)
    {
        $this->repuestoService->eliminar($id);

        return redirect()->route('panel.repuestos.index')
            ->with('success', 'Repuesto eliminado correctamente.');
    }
}

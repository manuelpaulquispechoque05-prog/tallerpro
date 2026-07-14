<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\MecanicoService;
use App\Services\EspecialidadService;
use App\Services\SucursalService;
use Illuminate\Http\Request;

class MecanicoController extends Controller
{
    public function __construct(
        protected MecanicoService $mecanicoService,
        protected EspecialidadService $especialidadService,
        protected SucursalService $sucursalService
    ) {}

    public function index(Request $r)
    {
        return view('panel.mecanicos.index', ['items' => $this->mecanicoService->listar($r->get('busqueda'))]);
    }

    public function create()
    {
        return view('panel.mecanicos.create', [
            'especialidades' => $this->especialidadService->obtenerTodas(),
            'sucursales' => $this->sucursalService->activas(),
        ]);
    }

    public function store(Request $r)
    {
        $v = $r->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'ci' => 'nullable|string|max:20|unique:mecanicos,ci',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'especialidad_id' => 'required|exists:especialidades,id',
            'sucursal_id' => 'required|exists:sucursales,id',
            'fecha_contratacion' => 'required|date',
            'descripcion' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $this->mecanicoService->crear($v);
        return redirect()->route('panel.mecanicos.index')->with('success', 'Mecanico registrado.');
    }

    public function show(int $id)
    {
        return view('panel.mecanicos.show', ['item' => $this->mecanicoService->obtenerPorId($id)]);
    }

    public function edit(int $id)
    {
        $item = $this->mecanicoService->obtenerPorId($id);
        $especialidades = $this->especialidadService->obtenerTodas();
        $sucursales = $this->sucursalService->activas();
        return view('panel.mecanicos.edit', compact('item', 'especialidades', 'sucursales'));
    }

    public function update(Request $r, int $id)
    {
        $v = $r->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'ci' => 'nullable|string|max:20|unique:mecanicos,ci,' . $id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'especialidad_id' => 'required|exists:especialidades,id',
            'sucursal_id' => 'required|exists:sucursales,id',
            'fecha_contratacion' => 'required|date',
            'descripcion' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:255',
            'activo' => 'nullable|boolean',
        ]);

        $this->mecanicoService->actualizar($id, $v);
        return redirect()->route('panel.mecanicos.index')->with('success', 'Mecanico actualizado.');
    }

    public function destroy(int $id)
    {
        $this->mecanicoService->eliminar($id);
        return redirect()->route('panel.mecanicos.index')->with('success', 'Mecanico eliminado.');
    }
}

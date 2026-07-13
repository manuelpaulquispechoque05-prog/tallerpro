<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\EspecialidadService;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    public function __construct(protected EspecialidadService $service) {}

    public function index(Request $r)
    {
        return view('panel.especialidades.index', ['items' => $this->service->listar($r->get('busqueda'))]);
    }

    public function create() { return view('panel.especialidades.create'); }

    public function store(Request $r)
    {
        $this->service->crear($r->validate(['nombre' => 'required|string|max:60|unique:especialidades,nombre']));
        return redirect()->route('panel.especialidades.index')->with('success', 'Especialidad creada.');
    }

    public function edit(int $id) { return view('panel.especialidades.edit', ['item' => $this->service->obtenerTodas()->find($id) ?? abort(404)]); }

    public function update(Request $r, int $id)
    {
        $this->service->actualizar($id, $r->validate(['nombre' => 'required|string|max:60|unique:especialidades,nombre,' . $id]));
        return redirect()->route('panel.especialidades.index')->with('success', 'Especialidad actualizada.');
    }

    public function destroy(int $id)
    {
        $this->service->eliminar($id);
        return redirect()->route('panel.especialidades.index')->with('success', 'Especialidad eliminada.');
    }
}

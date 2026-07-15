<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\SucursalRequest;
use App\Services\SucursalService;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function __construct(
        protected SucursalService $sucursalService
    ) {}

    public function index(Request $r)
    {
        return view('panel.sucursales.index', ['items' => $this->sucursalService->listar($r->get('busqueda'))]);
    }

    public function create()
    {
        return view('panel.sucursales.create');
    }

    public function store(SucursalRequest $r)
    {
        $this->sucursalService->crear($r->validated());
        return redirect()->route('panel.sucursales.index')->with('success', 'Sucursal creada.');
    }

    public function edit(int $id)
    {
        return view('panel.sucursales.edit', ['item' => $this->sucursalService->obtenerPorId($id)]);
    }

    public function update(SucursalRequest $r, int $id)
    {
        $this->sucursalService->actualizar($id, $r->validated());
        return redirect()->route('panel.sucursales.index')->with('success', 'Sucursal actualizada.');
    }

    public function destroy(int $id)
    {
        $this->sucursalService->eliminar($id);
        return redirect()->route('panel.sucursales.index')->with('success', 'Sucursal eliminada.');
    }
}

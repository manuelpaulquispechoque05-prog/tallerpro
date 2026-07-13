<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\CategoriaRepuestoService;
use Illuminate\Http\Request;

class CategoriaRepuestoController extends Controller
{
    public function __construct(
        protected CategoriaRepuestoService $service
    ) {}

    public function index(Request $request)
    {
        $items = $this->service->listar($request->get('busqueda'));
        return view('panel.categorias.index', compact('items'));
    }

    public function create()
    {
        return view('panel.categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:80|unique:categorias_repuesto,nombre',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $this->service->crear($validated);
        return redirect()->route('panel.categorias.index')->with('success', 'Categoria creada.');
    }

    public function edit(int $id)
    {
        $item = $this->service->obtenerPorId($id);
        return view('panel.categorias.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:80|unique:categorias_repuesto,nombre,' . $id,
            'descripcion' => 'nullable|string|max:255',
        ]);

        $this->service->actualizar($id, $validated);
        return redirect()->route('panel.categorias.index')->with('success', 'Categoria actualizada.');
    }

    public function destroy(int $id)
    {
        $this->service->eliminar($id);
        return redirect()->route('panel.categorias.index')->with('success', 'Categoria eliminada.');
    }
}

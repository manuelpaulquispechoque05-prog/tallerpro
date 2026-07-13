<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\ProveedorService;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function __construct(
        protected ProveedorService $service
    ) {}

    public function index(Request $request)
    {
        $items = $this->service->listar($request->get('busqueda'));
        return view('panel.proveedores.index', compact('items'));
    }

    public function create()
    {
        return view('panel.proveedores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'nit' => 'nullable|string|max:30',
            'contacto' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'direccion' => 'nullable|string|max:255',
        ]);

        $this->service->crear($validated);
        return redirect()->route('panel.proveedores.index')->with('success', 'Proveedor creado.');
    }

    public function edit(int $id)
    {
        $item = $this->service->obtenerPorId($id);
        return view('panel.proveedores.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'nit' => 'nullable|string|max:30',
            'contacto' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'direccion' => 'nullable|string|max:255',
        ]);

        $this->service->actualizar($id, $validated);
        return redirect()->route('panel.proveedores.index')->with('success', 'Proveedor actualizado.');
    }

    public function destroy(int $id)
    {
        $this->service->eliminar($id);
        return redirect()->route('panel.proveedores.index')->with('success', 'Proveedor eliminado.');
    }
}

<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\StoreClienteRequest;
use App\Http\Requests\Panel\UpdateClienteRequest;
use App\Services\ClienteService;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct(
        protected ClienteService $clienteService
    ) {}

    public function index(Request $request)
    {
        $busqueda = $request->get('busqueda');
        $ordenarPor = $request->get('ordenar_por', 'created_at');
        $direccion = $request->get('direccion', 'desc');

        $clientes = $this->clienteService->listar($busqueda, $ordenarPor, $direccion);

        return view('panel.clientes.index', compact('clientes', 'busqueda', 'ordenarPor', 'direccion'));
    }

    public function create()
    {
        return view('panel.clientes.create');
    }

    public function store(StoreClienteRequest $request)
    {
        $this->clienteService->crear($request->validated());

        return redirect()->route('panel.clientes.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    public function show(int $id)
    {
        $cliente = $this->clienteService->obtenerPorId($id);
        return view('panel.clientes.show', compact('cliente'));
    }

    public function edit(int $id)
    {
        $cliente = $this->clienteService->obtenerPorId($id);
        return view('panel.clientes.edit', compact('cliente'));
    }

    public function update(UpdateClienteRequest $request, int $id)
    {
        $this->clienteService->actualizar($id, $request->validated());

        return redirect()->route('panel.clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(int $id)
    {
        $this->clienteService->eliminar($id);

        return redirect()->route('panel.clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}

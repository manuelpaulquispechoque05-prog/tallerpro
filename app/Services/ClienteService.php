<?php

namespace App\Services;

use App\Models\Cliente;

class ClienteService
{
    public function listar(string $busqueda = null, string $ordenarPor = 'created_at', string $direccion = 'desc')
    {
        $columnasPermitidas = ['id', 'nombre', 'apellido', 'ci_nit', 'telefono', 'email', 'created_at'];

        if (!in_array($ordenarPor, $columnasPermitidas)) {
            $ordenarPor = 'created_at';
        }

        return Cliente::when($busqueda, fn($q) => $q->search($busqueda))
            ->orderBy($ordenarPor, $direccion === 'asc' ? 'asc' : 'desc')
            ->paginate(10)
            ->withQueryString();
    }

    public function obtenerPorId(int $id): Cliente
    {
        return Cliente::withCount(['vehiculos', 'citas', 'ordenesTrabajo'])->findOrFail($id);
    }

    public function crear(array $data): Cliente
    {
        return Cliente::create([
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'ci_nit' => $data['ci_nit'],
            'telefono' => $data['telefono'],
            'email' => $data['email'] ?? null,
            'direccion' => $data['direccion'] ?? null,
            'activo' => true,
        ]);
    }

    public function actualizar(int $id, array $data): Cliente
    {
        $cliente = Cliente::findOrFail($id);

        $cliente->update([
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'ci_nit' => $data['ci_nit'],
            'telefono' => $data['telefono'],
            'email' => $data['email'] ?? $cliente->email,
            'direccion' => $data['direccion'] ?? $cliente->direccion,
        ]);

        return $cliente;
    }

    public function eliminar(int $id): void
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
    }
}

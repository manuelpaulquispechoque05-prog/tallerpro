<?php

namespace App\Services;

use App\Models\Proveedor;

class ProveedorService
{
    public function listar(string $busqueda = null)
    {
        return Proveedor::when($busqueda, fn($q) => $q->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', "%{$busqueda}%")
                  ->orWhere('contacto', 'like', "%{$busqueda}%")
                  ->orWhere('nit', 'like', "%{$busqueda}%");
            }))
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();
    }

    public function obtenerPorId(int $id): Proveedor
    {
        return Proveedor::findOrFail($id);
    }

    public function crear(array $data): Proveedor
    {
        return Proveedor::create([
            'nombre' => $data['nombre'],
            'nit' => $data['nit'] ?? null,
            'contacto' => $data['contacto'] ?? null,
            'telefono' => $data['telefono'] ?? null,
            'email' => $data['email'] ?? null,
            'direccion' => $data['direccion'] ?? null,
            'activo' => true,
        ]);
    }

    public function actualizar(int $id, array $data): Proveedor
    {
        $item = Proveedor::findOrFail($id);
        $item->update([
            'nombre' => $data['nombre'],
            'nit' => $data['nit'] ?? $item->nit,
            'contacto' => $data['contacto'] ?? $item->contacto,
            'telefono' => $data['telefono'] ?? $item->telefono,
            'email' => $data['email'] ?? $item->email,
            'direccion' => $data['direccion'] ?? $item->direccion,
        ]);
        return $item;
    }

    public function eliminar(int $id): void
    {
        Proveedor::findOrFail($id)->delete();
    }
}

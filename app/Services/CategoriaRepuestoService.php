<?php

namespace App\Services;

use App\Models\CategoriaRepuesto;

class CategoriaRepuestoService
{
    public function listar(string $busqueda = null)
    {
        return CategoriaRepuesto::when($busqueda, fn($q) => $q->where('nombre', 'like', "%{$busqueda}%"))
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();
    }

    public function obtenerPorId(int $id): CategoriaRepuesto
    {
        return CategoriaRepuesto::findOrFail($id);
    }

    public function crear(array $data): CategoriaRepuesto
    {
        return CategoriaRepuesto::create(['nombre' => $data['nombre'], 'descripcion' => $data['descripcion'] ?? null]);
    }

    public function actualizar(int $id, array $data): CategoriaRepuesto
    {
        $item = CategoriaRepuesto::findOrFail($id);
        $item->update(['nombre' => $data['nombre'], 'descripcion' => $data['descripcion'] ?? $item->descripcion]);
        return $item;
    }

    public function eliminar(int $id): void
    {
        CategoriaRepuesto::findOrFail($id)->delete();
    }
}

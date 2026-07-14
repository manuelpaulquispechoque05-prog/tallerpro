<?php

namespace App\Services;

use App\Models\Sucursal;

class SucursalService
{
    public function listar(string $busqueda = null)
    {
        return Sucursal::when($busqueda, fn($q) => $q->where('nombre', 'like', "%{$busqueda}%")
            ->orWhere('ciudad', 'like', "%{$busqueda}%"))
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();
    }

    public function activas()
    {
        return Sucursal::where('activo', true)->orderBy('nombre')->get();
    }

    public function obtenerPorId(int $id): Sucursal
    {
        return Sucursal::findOrFail($id);
    }

    public function crear(array $data): Sucursal
    {
        return Sucursal::create([
            'nombre' => $data['nombre'],
            'direccion' => $data['direccion'],
            'telefono' => $data['telefono'] ?? null,
            'ciudad' => $data['ciudad'],
            'activo' => true,
        ]);
    }

    public function actualizar(int $id, array $data): Sucursal
    {
        $s = Sucursal::findOrFail($id);
        $s->update([
            'nombre' => $data['nombre'],
            'direccion' => $data['direccion'],
            'telefono' => $data['telefono'] ?? $s->telefono,
            'ciudad' => $data['ciudad'],
            'activo' => $data['activo'] ?? $s->activo,
        ]);
        return $s;
    }

    public function eliminar(int $id): void
    {
        Sucursal::findOrFail($id)->delete();
    }
}

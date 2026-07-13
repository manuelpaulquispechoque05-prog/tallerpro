<?php

namespace App\Services;

use App\Models\Especialidad;

class EspecialidadService
{
    public function listar(string $busqueda = null)
    {
        return Especialidad::when($busqueda, fn($q) => $q->where('nombre', 'like', "%{$busqueda}%"))
            ->orderBy('nombre')->paginate(10)->withQueryString();
    }

    public function obtenerTodas()
    {
        return Especialidad::orderBy('nombre')->get();
    }

    public function crear(array $data): Especialidad
    {
        return Especialidad::create(['nombre' => $data['nombre']]);
    }

    public function actualizar(int $id, array $data): Especialidad
    {
        $item = Especialidad::findOrFail($id);
        $item->update(['nombre' => $data['nombre']]);
        return $item;
    }

    public function eliminar(int $id): void
    {
        Especialidad::findOrFail($id)->delete();
    }
}

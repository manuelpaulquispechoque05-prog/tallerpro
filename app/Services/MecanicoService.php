<?php

namespace App\Services;

use App\Models\Mecanico;

class MecanicoService
{
    public function listar(string $busqueda = null)
    {
        return Mecanico::with('especialidad')
            ->when($busqueda, fn($q) => $q->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', "%{$busqueda}%")
                  ->orWhere('apellidos', 'like', "%{$busqueda}%")
                  ->orWhere('ci', 'like', "%{$busqueda}%")
                  ->orWhere('telefono', 'like', "%{$busqueda}%");
            }))
            ->orderBy('nombre')
            ->paginate(10)->withQueryString();
    }

    public function obtenerPorId(int $id): Mecanico
    {
        return Mecanico::with('especialidad', 'sucursal')
            ->withCount([
                'citas as citas_asignadas' => fn($q) => $q->whereIn('estado', ['asignada', 'atendida']),
                'ordenesTrabajo as ordenes_activas' => fn($q) => $q->where('estado', 'en_proceso'),
                'ordenesTrabajo as ordenes_finalizadas' => fn($q) => $q->where('estado', 'completado'),
            ])
            ->findOrFail($id);
    }

    public function crear(array $data): Mecanico
    {
        return Mecanico::create([
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'ci' => $data['ci'] ?? null,
            'telefono' => $data['telefono'] ?? null,
            'direccion' => $data['direccion'] ?? null,
            'especialidad_id' => $data['especialidad_id'],
            'sucursal_id' => $data['sucursal_id'] ?? 1,
            'descripcion' => $data['descripcion'] ?? null,
            'observaciones' => $data['observaciones'] ?? null,
            'foto' => $data['foto'] ?? null,
            'fecha_contratacion' => $data['fecha_contratacion'],
            'activo' => true,
        ]);
    }

    public function actualizar(int $id, array $data): Mecanico
    {
        $m = Mecanico::findOrFail($id);
        $m->update([
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'ci' => $data['ci'] ?? $m->ci,
            'telefono' => $data['telefono'] ?? $m->telefono,
            'direccion' => $data['direccion'] ?? $m->direccion,
            'especialidad_id' => $data['especialidad_id'],
            'sucursal_id' => $data['sucursal_id'] ?? $m->sucursal_id,
            'descripcion' => $data['descripcion'] ?? $m->descripcion,
            'observaciones' => $data['observaciones'] ?? $m->observaciones,
            'fecha_contratacion' => $data['fecha_contratacion'],
            'activo' => $data['activo'] ?? $m->activo,
        ]);
        return $m;
    }

    public function eliminar(int $id): void
    {
        Mecanico::findOrFail($id)->delete();
    }

    public function activos()
    {
        return Mecanico::where('activo', true)->with('especialidad')->orderBy('nombre')->get();
    }

    public function kpis(): array
    {
        return [
            'total_mecanicos' => Mecanico::where('activo', true)->count(),
            'mecanicos_disponibles' => Mecanico::where('activo', true)
                ->whereDoesntHave('ordenesTrabajo', fn($q) => $q->where('estado', 'en_proceso'))
                ->count(),
        ];
    }
}

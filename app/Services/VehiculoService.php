<?php

namespace App\Services;

use App\Models\MarcaVehiculo;
use App\Models\Vehiculo;

class VehiculoService
{
    public function listar(string $busqueda = null, string $ordenarPor = 'created_at', string $direccion = 'desc')
    {
        $columnas = ['id', 'placa', 'anio', 'created_at'];

        if (!in_array($ordenarPor, $columnas)) {
            $ordenarPor = 'created_at';
        }

        return Vehiculo::with('cliente', 'marca', 'modelo')
            ->when($busqueda, fn($q) => $q->where(function ($q) use ($busqueda) {
                $q->where('placa', 'like', "%{$busqueda}%")
                  ->orWhere('vin', 'like', "%{$busqueda}%")
                  ->orWhereHas('cliente', fn($c) => $c->where('nombre', 'like', "%{$busqueda}%")
                      ->orWhere('apellido', 'like', "%{$busqueda}%")
                      ->orWhere('ci_nit', 'like', "%{$busqueda}%"));
            }))
            ->orderBy($ordenarPor, $direccion === 'asc' ? 'asc' : 'desc')
            ->paginate(10)
            ->withQueryString();
    }

    public function obtenerPorId(int $id): Vehiculo
    {
        return Vehiculo::with('cliente', 'marca', 'modelo')->findOrFail($id);
    }

    public function crear(array $data): Vehiculo
    {
        return Vehiculo::create([
            'cliente_id' => $data['cliente_id'],
            'marca_id' => $data['marca_id'],
            'modelo_id' => $data['modelo_id'],
            'anio' => $data['anio'],
            'placa' => $data['placa'],
            'vin' => $data['vin'] ?? null,
            'color' => $data['color'] ?? null,
            'kilometraje' => $data['kilometraje'] ?? 0,
            'activo' => true,
        ]);
    }

    public function actualizar(int $id, array $data): Vehiculo
    {
        $vehiculo = Vehiculo::findOrFail($id);

        $vehiculo->update([
            'cliente_id' => $data['cliente_id'],
            'marca_id' => $data['marca_id'],
            'modelo_id' => $data['modelo_id'],
            'anio' => $data['anio'],
            'placa' => $data['placa'],
            'vin' => $data['vin'] ?? $vehiculo->vin,
            'color' => $data['color'] ?? $vehiculo->color,
            'kilometraje' => $data['kilometraje'] ?? $vehiculo->kilometraje,
        ]);

        return $vehiculo;
    }

    public function eliminar(int $id): void
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->delete();
    }

    public function obtenerMarcas()
    {
        return MarcaVehiculo::orderBy('nombre')->get();
    }

    public function obtenerModelosPorMarca(int $marcaId)
    {
        return \App\Models\ModeloVehiculo::where('marca_id', $marcaId)
            ->orderBy('nombre')
            ->get();
    }

    public function buscarClientes(string $term)
    {
        return \App\Models\Cliente::where('activo', true)
            ->where(function ($q) use ($term) {
                $q->where('nombre', 'like', "%{$term}%")
                  ->orWhere('apellido', 'like', "%{$term}%")
                  ->orWhere('ci_nit', 'like', "%{$term}%");
            })
            ->orderBy('nombre')
            ->take(10)
            ->get(['id', 'nombre', 'apellido', 'ci_nit', 'telefono']);
    }
}

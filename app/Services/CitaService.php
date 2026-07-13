<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\Mecanico;

class CitaService
{
    public function listar(string $busqueda = null, string $estadoFiltro = null, string $ordenarPor = 'fecha_hora', string $direccion = 'asc')
    {
        $columnas = ['id', 'fecha_hora', 'estado', 'created_at'];

        if (!in_array($ordenarPor, $columnas)) {
            $ordenarPor = 'fecha_hora';
        }

        return Cita::with('cliente', 'servicio', 'tipoVehiculo', 'mecanico')
            ->when($busqueda, fn($q) => $q->where(function ($q) use ($busqueda) {
                $q->whereHas('cliente', fn($c) => $c->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('apellido', 'like', "%{$busqueda}%")
                    ->orWhere('ci_nit', 'like', "%{$busqueda}%"));
            }))
            ->when($estadoFiltro, fn($q) => $q->where('estado', $estadoFiltro))
            ->orderBy($ordenarPor, $direccion === 'asc' ? 'asc' : 'desc')
            ->paginate(10)
            ->withQueryString();
    }

    public function obtenerPorId(int $id): Cita
    {
        return Cita::with('cliente', 'servicio', 'tipoVehiculo', 'vehiculo', 'mecanico', 'sucursal', 'ordenTrabajo')
            ->findOrFail($id);
    }

    public function confirmar(int $id): Cita
    {
        $cita = Cita::findOrFail($id);

        if ($cita->estado !== 'pendiente') {
            throw new \RuntimeException('Solo se pueden confirmar citas en estado pendiente.');
        }

        $cita->update(['estado' => 'confirmada']);
        return $cita;
    }

    public function asignarMecanico(int $id, int $mecanicoId): Cita
    {
        $cita = Cita::findOrFail($id);

        if (!in_array($cita->estado, ['confirmada', 'pendiente'])) {
            throw new \RuntimeException('Solo se puede asignar mecanico a citas confirmadas o pendientes.');
        }

        $mecanico = Mecanico::findOrFail($mecanicoId);

        $cita->update([
            'mecanico_id' => $mecanico->id,
            'estado' => 'asignada',
        ]);

        return $cita;
    }

    public function cancelar(int $id): Cita
    {
        $cita = Cita::findOrFail($id);

        if (in_array($cita->estado, ['atendida'])) {
            throw new \RuntimeException('No se puede cancelar una cita ya atendida.');
        }

        $cita->update(['estado' => 'cancelada']);
        return $cita;
    }

    public function obtenerMecanicosDisponibles()
    {
        return Mecanico::where('activo', true)
            ->with('especialidad')
            ->orderBy('nombre')
            ->get();
    }
}

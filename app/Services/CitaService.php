<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\Mecanico;
use Illuminate\Support\Facades\DB;

class CitaService
{
    public function __construct(
        protected OrdenTrabajoService $ordenTrabajoService,
        protected DisponibilidadCitaService $disponibilidadService,
    ) {}

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
        $cita = Cita::with('vehiculo', 'ordenTrabajo')->findOrFail($id);

        if (!in_array($cita->estado, ['confirmada', 'asignada'])) {
            throw new \RuntimeException('No se puede asignar mecanico en el estado actual.');
        }

        // Si ya tiene orden, verificar estado para reasignacion
        if ($cita->orden_trabajo_id) {
            if (in_array($cita->ordenTrabajo->estado, ['completado', 'cancelado'])) {
                throw new \RuntimeException('No se puede reasignar mecanico. La orden esta ' . $cita->ordenTrabajo->estado);
            }
        }

        // Verificar disponibilidad del mecanico
        $disponible = $this->disponibilidadService->mecanicoDisponible(
            mecanicoId: $mecanicoId,
            sucursalId: $cita->sucursal_id,
            fecha: $cita->fecha_hora->format('Y-m-d'),
            hora: $cita->fecha_hora->format('H:i'),
            duracionMinutos: $cita->duracion_minutos,
            excluirCitaId: $cita->id,
        );

        if (!$disponible) {
            throw new \RuntimeException('El mecanico seleccionado no esta disponible en esa fecha y horario.');
        }

        $mecanico = Mecanico::findOrFail($mecanicoId);

        DB::transaction(function () use ($cita, $mecanico) {
            $cita->update([
                'mecanico_id' => $mecanico->id,
                'estado' => 'asignada',
            ]);

            // Si ya existe orden (reasignacion), actualizar mecanico
            if ($cita->orden_trabajo_id) {
                $cita->ordenTrabajo->update(['mecanico_id' => $mecanico->id]);
            }
        });

        $cita->refresh();
        return $cita;
    }

    /**
     * Vincula un vehiculo a una cita y crea la orden si ya hay mecanico asignado.
     */
    public function vincularVehiculo(int $citaId, int $vehiculoId, ?int $kilometraje = null): void
    {
        DB::transaction(function () use ($citaId, $vehiculoId, $kilometraje) {
            $cita = Cita::with('vehiculo', 'ordenTrabajo')->lockForUpdate()->findOrFail($citaId);

            if ($cita->vehiculo_id) {
                return; // Ya tiene vehiculo, no hacer nada
            }

            $cita->update([
                'vehiculo_id' => $vehiculoId,
            ]);

            // Si tiene mecanico asignado pero no orden, crearla ahora
            if ($cita->mecanico_id && !$cita->orden_trabajo_id) {
                $orden = $this->ordenTrabajoService->crearDesdeCita($cita->id);
                $cita->setRelation('ordenTrabajo', $orden);
            }
        });
    }

    public function cancelar(int $id): Cita
    {
        $cita = Cita::with('ordenTrabajo')->findOrFail($id);

        if (in_array($cita->estado, ['completada'])) {
            throw new \RuntimeException('No se puede cancelar una cita ya completada.');
        }

        $cita->update(['estado' => 'cancelada']);

        return $cita;
    }

    public function obtenerMecanicosDisponibles(Cita $cita)
    {
        $mecanicos = Mecanico::where('activo', true)
            ->with('especialidad')
            ->orderBy('nombre')
            ->get();

        // Marcar disponibilidad segun la cita
        foreach ($mecanicos as $m) {
            $m->disponible = $this->disponibilidadService->mecanicoDisponible(
                mecanicoId: $m->id,
                sucursalId: $cita->sucursal_id,
                fecha: $cita->fecha_hora->format('Y-m-d'),
                hora: $cita->fecha_hora->format('H:i'),
                duracionMinutos: $cita->duracion_minutos,
                excluirCitaId: $cita->id,
            );
        }

        return $mecanicos;
    }
}

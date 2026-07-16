<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\HorariosMecanico;
use App\Models\Mecanico;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DisponibilidadCitaService
{
    /**
     * Verifica si un mecanico especifico esta disponible para una cita.
     *
     * @param int $mecanicoId
     * @param int $sucursalId
     * @param string $fecha Y-m-d
     * @param string $hora H:i
     * @param int $duracionMinutos
     * @param int|null $excluirCitaId ID de cita a excluir (para reasignacion)
     * @return bool
     */
    public function mecanicoDisponible(int $mecanicoId, int $sucursalId, string $fecha, string $hora, int $duracionMinutos, ?int $excluirCitaId = null): bool
    {
        $mecanico = Mecanico::find($mecanicoId);
        if (!$mecanico || !$mecanico->activo) {
            return false;
        }

        if ($mecanico->sucursal_id !== $sucursalId) {
            return false;
        }

        $fechaCarbon = Carbon::parse($fecha);
        $diaSemana = $fechaCarbon->dayOfWeekIso;
        $inicio = Carbon::parse($fecha . ' ' . $hora);
        $fin = $inicio->copy()->addMinutes($duracionMinutos);

        // Verificar horario laboral
        $horario = HorariosMecanico::where('mecanico_id', $mecanicoId)
            ->where('dia_semana', $diaSemana)
            ->where('activo', true)
            ->first();

        if (!$horario) {
            return false;
        }

        $hInicio = Carbon::parse($fecha . ' ' . substr($horario->hora_inicio, 0, 5));
        $hFin = Carbon::parse($fecha . ' ' . substr($horario->hora_fin, 0, 5));

        // La cita debe empezar despues del inicio y terminar antes del fin del horario
        if ($inicio < $hInicio || $fin > $hFin) {
            return false;
        }

        // Si es hoy, verificar que no haya pasado + margen 30 min
        if ($fechaCarbon->isToday()) {
            $horaTope = Carbon::now()->addMinutes(30);
            if ($inicio < $horaTope) {
                return false;
            }
        }

        // Verificar solapamiento con otras citas
        $citasQuery = Cita::where('mecanico_id', $mecanicoId)
            ->whereDate('fecha_hora', $fecha)
            ->where('estado', '!=', 'cancelada')
            ->whereNotNull('mecanico_id');

        if ($excluirCitaId) {
            $citasQuery->where('id', '!=', $excluirCitaId);
        }

        $citas = $citasQuery->get(['id', 'fecha_hora', 'duracion_minutos']);

        foreach ($citas as $citaExistente) {
            $citaStart = Carbon::parse($citaExistente->fecha_hora);
            $citaEnd = $citaStart->copy()->addMinutes($citaExistente->duracion_minutos);

            // Hay traslape si: nuevoInicio < citaEnd AND nuevoFin > citaStart
            if ($inicio < $citaEnd && $fin > $citaStart) {
                return false;
            }
        }

        return true;
    }
    /**
     * Obtiene los slots disponibles para una sucursal en una fecha dada.
     *
     * @param int $sucursalId
     * @param string $fecha Formato 'Y-m-d'
     * @param int $duracionMinutos Duración del servicio
     * @return array
     */
    public function obtenerSlots(int $sucursalId, string $fecha, int $duracionMinutos): array
    {
        $fechaCarbon = Carbon::parse($fecha);
        $diaSemana = $fechaCarbon->dayOfWeekIso; // 1=Lunes ... 7=Domingo

        // 1. Mecánicos activos de la sucursal
        $mecanicos = Mecanico::where('activo', true)
            ->where('sucursal_id', $sucursalId)
            ->pluck('id');

        if ($mecanicos->isEmpty()) {
            return [];
        }

        // 2. Horarios de esos mecánicos para ese día
        $horarios = HorariosMecanico::whereIn('mecanico_id', $mecanicos)
            ->where('dia_semana', $diaSemana)
            ->where('activo', true)
            ->get()
            ->groupBy('mecanico_id');

        if ($horarios->isEmpty()) {
            return [];
        }

        // 3. Citas existentes para esa fecha (no canceladas)
        $citas = Cita::whereIn('mecanico_id', $mecanicos)
            ->whereDate('fecha_hora', $fecha)
            ->where('estado', '!=', 'cancelada')
            ->whereNotNull('mecanico_id')
            ->get(['mecanico_id', 'fecha_hora', 'duracion_minutos']);

        // 4. Determinar rango horario (el más amplio entre todos los mecánicos)
        $minHora = '23:59';
        $maxHora = '00:00';

        foreach ($horarios as $mecId => $horas) {
            foreach ($horas as $h) {
                if ($h->hora_inicio < $minHora) $minHora = $h->hora_inicio;
                if ($h->hora_fin > $maxHora) $maxHora = $h->hora_fin;
            }
        }

        // 5. Calcular hora tope: si es hoy, excluir horarios pasados + margen 30 min
        $horaTope = null;
        if ($fechaCarbon->isToday()) {
            $horaTope = Carbon::now()->addMinutes(30);
        }

        // 6. Generar slots
        $inicio = Carbon::parse($fecha . ' ' . substr($minHora, 0, 5));
        $fin = Carbon::parse($fecha . ' ' . substr($maxHora, 0, 5));
        $slots = [];

        while ($inicio->copy()->addMinutes($duracionMinutos) <= $fin) {
            // Saltar slots que ya pasaron (si es hoy)
            if ($horaTope && $inicio < $horaTope) {
                $inicio->addMinutes($duracionMinutos);
                continue;
            }

            $slotStart = $inicio->format('H:i');
            $slotEnd = $inicio->copy()->addMinutes($duracionMinutos)->format('H:i');
            $mecanicosLibres = 0;

            foreach ($mecanicos as $mecId) {
                $tieneHorario = false;
                $ocupado = false;

                // Verificar si el mecánico trabaja en este slot
                if (isset($horarios[$mecId])) {
                    foreach ($horarios[$mecId] as $h) {
                        $hInicio = substr($h->hora_inicio, 0, 5);
                        $hFin = substr($h->hora_fin, 0, 5);
                        if ($inicio->format('H:i') >= $hInicio
                            && $inicio->copy()->addMinutes($duracionMinutos)->format('H:i') <= $hFin) {
                            $tieneHorario = true;
                            break;
                        }
                    }
                }

                if (!$tieneHorario) continue;

                // Verificar si el mecánico tiene una cita que se traslape
                foreach ($citas->where('mecanico_id', $mecId) as $cita) {
                    $citaStart = Carbon::parse($cita->fecha_hora);
                    $citaEnd = $citaStart->copy()->addMinutes($cita->duracion_minutos);
                    $slotEndCarbon = $inicio->copy()->addMinutes($duracionMinutos);

                    // Hay traslape si: slotStart < citaEnd AND slotEnd > citaStart
                    if ($inicio < $citaEnd && $slotEndCarbon > $citaStart) {
                        $ocupado = true;
                        break;
                    }
                }

                if (!$ocupado) {
                    $mecanicosLibres++;
                }
            }

            $slots[] = [
                'hora' => $slotStart,
                'hora_fin' => $slotEnd,
                'disponible' => $mecanicosLibres > 0,
                'mecanicos_libres' => $mecanicosLibres,
            ];

            $inicio->addMinutes($duracionMinutos);
        }

        return $slots;
    }
}

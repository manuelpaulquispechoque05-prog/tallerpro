<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Sucursal;
use App\Services\DisponibilidadCitaService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function __construct(
        protected DisponibilidadCitaService $disponibilidadService
    ) {}

    public function index()
    {
        $cliente = auth()->user()->cliente;

        if (!$cliente) {
            return view('portal.citas.index', ['citas' => collect()]);
        }

        $citas = Cita::with(['servicio', 'tipoVehiculo', 'mecanico', 'vehiculo'])
            ->where('cliente_id', $cliente->id)
            ->orderBy('fecha_hora', 'desc')
            ->get();

        return view('portal.citas.index', compact('citas'));
    }

    public function create()
    {
        $cliente = auth()->user()->cliente;

        if (!$cliente) {
            return redirect()->route('portal.citas.index')
                ->with('error', 'Completa tu perfil antes de reservar.');
        }

        $cliente->load('vehiculos');
        $sucursales = Sucursal::where('activo', true)->orderBy('nombre')->get();
        $servicios = Servicio::where('activo', true)->orderBy('nombre')->get();
        $vehiculos = $cliente->vehiculos;

        return view('portal.citas.create', compact('sucursales', 'servicios', 'vehiculos', 'cliente'));
    }

    public function disponibilidad(Request $request)
    {
        $request->validate([
            'sucursal_id' => 'required|exists:sucursales,id',
            'servicio_id' => 'required|exists:servicios,id',
            'fecha' => 'required|date|after_or_equal:today',
        ]);

        $servicio = Servicio::findOrFail($request->servicio_id);

        $slots = $this->disponibilidadService->obtenerSlots(
            $request->sucursal_id,
            $request->fecha,
            $servicio->duracion_estimada_min
        );

        $fechaCarbon = Carbon::parse($request->fecha);

        return response()->json([
            'slots' => $slots,
            'duracion' => $servicio->duracion_estimada_min,
            'es_hoy' => $fechaCarbon->isToday(),
        ]);
    }

    public function store(Request $request)
    {
        $cliente = auth()->user()->cliente;

        if (!$cliente) {
            return redirect()->route('portal.citas.index')
                ->with('error', 'Completa tu perfil antes de reservar.');
        }

        $validated = $request->validate([
            'sucursal_id' => 'required|exists:sucursales,id',
            'servicio_id' => 'required|exists:servicios,id',
            'tipo_solicitud' => 'required|in:servicio,diagnostico',
            'tipo_vehiculo_id' => 'required|exists:tipos_vehiculo,id',
            'vehiculo_id' => 'nullable|exists:vehiculos,id',
            'descripcion_problema' => 'nullable|string|max:500',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
        ]);

        $servicio = Servicio::findOrFail($validated['servicio_id']);
        $fechaHora = $validated['fecha'] . ' ' . $validated['hora'];

        // Validar que el horario esté disponible
        $slots = $this->disponibilidadService->obtenerSlots(
            $validated['sucursal_id'],
            $validated['fecha'],
            $servicio->duracion_estimada_min
        );

        $slotValido = collect($slots)->firstWhere('hora', $validated['hora']);

        if (!$slotValido || !$slotValido['disponible']) {
            return redirect()->back()->withInput()
                ->with('error', 'El horario seleccionado ya no esta disponible. Elige otro.');
        }

        $cita = Cita::create([
            'cliente_id' => $cliente->id,
            'tipo_solicitud' => $validated['tipo_solicitud'],
            'servicio_id' => $validated['servicio_id'],
            'descripcion_problema' => $validated['descripcion_problema'] ?? null,
            'tipo_vehiculo_id' => $validated['tipo_vehiculo_id'],
            'vehiculo_id' => $validated['vehiculo_id'] ?? null,
            'sucursal_id' => $validated['sucursal_id'],
            'duracion_minutos' => $servicio->duracion_estimada_min,
            'fecha_hora' => $fechaHora,
            'estado' => 'pendiente',
            'mecanico_id' => null,
        ]);

        return redirect()->route('portal.citas.index')
            ->with('success', 'Cita reservada correctamente. Te confirmaremos pronto.');
    }
}

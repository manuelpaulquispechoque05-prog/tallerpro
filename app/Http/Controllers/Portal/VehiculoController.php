<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\MarcaVehiculo;
use App\Models\ModeloVehiculo;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehiculoController extends Controller
{
    public function index()
    {
        $cliente = auth()->user()->cliente;

        if (!$cliente) {
            return view('portal.vehiculos.index', ['vehiculos' => collect()]);
        }

        $cliente->load('vehiculos.marca', 'vehiculos.modelo');

        return view('portal.vehiculos.index', ['vehiculos' => $cliente->vehiculos]);
    }

    public function create()
    {
        $marcas = MarcaVehiculo::orderBy('nombre')->get();
        return view('portal.vehiculos.create', compact('marcas'));
    }

    public function store(Request $request)
    {
        $cliente = auth()->user()->cliente;

        if (!$cliente) {
            return redirect()->route('portal.vehiculos.index')
                ->with('error', 'Debes completar tu perfil de cliente antes de registrar un vehiculo.');
        }

        $validated = $request->validate([
            'marca_id' => 'required|exists:marcas_vehiculo,id',
            'modelo_id' => 'required|exists:modelos_vehiculo,id',
            'anio' => 'required|integer|min:1990|max:2030',
            'placa' => 'required|string|max:15|unique:vehiculos,placa',
            'vin' => 'nullable|string|max:17|unique:vehiculos,vin',
            'color' => 'nullable|string|max:30',
            'kilometraje' => 'nullable|integer|min:0',
        ]);

        // Verificar que el modelo pertenezca a la marca seleccionada
        $modelo = ModeloVehiculo::where('id', $validated['modelo_id'])
            ->where('marca_id', $validated['marca_id'])
            ->exists();

        if (!$modelo) {
            return redirect()->back()->withInput()
                ->withErrors(['modelo_id' => 'El modelo seleccionado no corresponde a la marca elegida.']);
        }

        Vehiculo::create([
            'cliente_id' => $cliente->id,
            'marca_id' => $validated['marca_id'],
            'modelo_id' => $validated['modelo_id'],
            'anio' => $validated['anio'],
            'placa' => $validated['placa'],
            'vin' => $validated['vin'] ?? null,
            'color' => $validated['color'] ?? null,
            'kilometraje' => $validated['kilometraje'] ?? 0,
            'activo' => true,
        ]);

        return redirect()->route('portal.vehiculos.index')
            ->with('success', 'Vehiculo registrado correctamente.');
    }

    public function show(int $id)
    {
        $cliente = auth()->user()->cliente;

        if (!$cliente) {
            return redirect()->route('portal.vehiculos.index');
        }

        $vehiculo = Vehiculo::with(['marca', 'modelo', 'ordenesTrabajo'])
            ->where('id', $id)
            ->where('cliente_id', $cliente->id)
            ->firstOrFail();

        return view('portal.vehiculos.show', compact('vehiculo'));
    }

    // ─── Endpoint JSON para selector marca → modelo ────────────────

    public function modelosPorMarca(int $marcaId)
    {
        return response()->json(
            ModeloVehiculo::where('marca_id', $marcaId)
                ->orderBy('nombre')
                ->get()
        );
    }
}

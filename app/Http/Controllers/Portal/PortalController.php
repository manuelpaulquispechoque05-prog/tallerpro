<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cliente = $user?->cliente;

        $cliente?->loadMissing(['vehiculos', 'citas', 'ordenesTrabajo']);

        return view('portal.dashboard', compact('user', 'cliente'));
    }

    public function perfil()
    {
        $user = auth()->user();
        $cliente = $user?->cliente;

        if (!$cliente) {
            return redirect()->route('portal.inicio')
                ->with('error', 'Completa tu registro antes de acceder al perfil.');
        }

        return view('portal.perfil', compact('user', 'cliente'));
    }

    public function perfilUpdate(Request $request)
    {
        $user = auth()->user();
        $cliente = $user?->cliente;

        if (!$cliente) {
            return redirect()->route('portal.inicio')
                ->with('error', 'Completa tu registro antes de actualizar tu perfil.');
        }

        $validated = $request->validate([
            'telefono' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        $cliente->update([
            'telefono' => $validated['telefono'],
            'direccion' => $validated['direccion'] ?? $cliente->direccion,
        ]);

        return redirect()->route('portal.perfil')
            ->with('success', 'Perfil actualizado correctamente.');
    }
}

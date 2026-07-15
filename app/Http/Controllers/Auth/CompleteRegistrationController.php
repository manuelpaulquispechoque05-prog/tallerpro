<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompleteRegistrationController extends Controller
{
    public function show(Request $request)
    {
        $data = $request->session()->get('google_register');

        if (!$data) {
            return redirect()->route('login')
                ->with('error', 'Sesion expirada. Por favor inicia sesion con Google nuevamente.');
        }

        return view('auth.complete-registration', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $sessionData = $request->session()->get('google_register');

        if (!$sessionData) {
            return redirect()->route('login')
                ->with('error', 'Sesion expirada. Por favor inicia sesion con Google nuevamente.');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'ci_nit' => 'required|string|max:20|unique:clientes,ci_nit',
            'telefono' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $rolCliente = DB::table('roles')->where('nombre', 'Cliente')->value('id');

        $user = new User();
        $user->forceFill([
            'name'              => $validated['nombre'] . ' ' . $validated['apellido'],
            'email'             => $sessionData['email'],
            'password'          => Hash::make($validated['password']),
            'provider'          => $sessionData['provider'],
            'provider_id'       => $sessionData['provider_id'],
            'avatar'            => $sessionData['avatar'] ?? null,
            'rol_id'            => $rolCliente,
            'email_verified_at' => now(),
        ]);
        $user->save();

        Cliente::create([
            'user_id'   => $user->id,
            'nombre'    => $validated['nombre'],
            'apellido'  => $validated['apellido'],
            'ci_nit'    => $validated['ci_nit'],
            'telefono'  => $validated['telefono'],
            'email'     => $sessionData['email'],
            'direccion' => $validated['direccion'] ?? null,
            'activo'    => true,
        ]);

        $request->session()->forget('google_register');

        Auth::login($user);

        return redirect()->intended(route('portal.inicio'));
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirige al usuario a Google para autenticarse.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Recibe la respuesta de Google después de la autenticación.
     *
     * Usamos stateless() para evitar problemas de estado de sesión
     * entre el request de redirección y el callback.
     *
     * Si el usuario ya existe por email, vinculamos la cuenta de Google.
     * Si no, creamos un usuario nuevo con email_verified_at marcado
     * (Google ya verificó el correo por nosotros).
     */
    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Buscar por provider_id primero (evitar duplicados de Google),
        // luego por email como respaldo (vincular cuentas existentes)
        $user = User::where('provider_id', $googleUser->id)
            ->orWhere('email', $googleUser->email)
            ->first();

        if ($user) {
            // Si el usuario existía pero sin provider_id, vinculamos Google
            if (is_null($user->provider_id)) {
                $user->update([
                    'provider'    => 'google',
                    'provider_id' => $googleUser->id,
                    'avatar'      => $googleUser->avatar,
                ]);
            }
        } else {
            // Crear usuario nuevo con datos de Google
            $user = User::create([
                'name'              => $googleUser->name,
                'email'             => $googleUser->email,
                'provider'          => 'google',
                'provider_id'       => $googleUser->id,
                'avatar'            => $googleUser->avatar,
                'email_verified_at' => now(), // Google ya verificó el correo
                'password'          => null,   // Sin contraseña, login solo por Google
            ]);
        }

        // Iniciar sesión y redirigir al dashboard
        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}

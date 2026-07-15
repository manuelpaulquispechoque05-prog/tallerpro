<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('provider_id', $googleUser->id)
            ->orWhere('email', $googleUser->email)
            ->first();

        if ($user) {
            if (is_null($user->provider_id)) {
                $user->forceFill([
                    'provider'    => 'google',
                    'provider_id' => $googleUser->id,
                    'avatar'      => $googleUser->avatar,
                ])->save();
            }
        } else {
            $rolCliente = DB::table('roles')->where('nombre', 'Cliente')->first();
            $rolClienteId = $rolCliente?->id;

            $user = User::create([
                'name'              => $googleUser->name,
                'email'             => $googleUser->email,
                'avatar'            => $googleUser->avatar,
                'rol_id'            => $rolClienteId,
                'email_verified_at' => now(),
            ]);

            $user->forceFill([
                'provider'    => 'google',
                'provider_id' => $googleUser->id,
            ])->save();
        }

        Auth::login($user);

        if ($user->esCliente()) {
            return redirect()->intended(route('portal.inicio'));
        }

        return redirect()->intended(route('panel.dashboard'));
    }
}

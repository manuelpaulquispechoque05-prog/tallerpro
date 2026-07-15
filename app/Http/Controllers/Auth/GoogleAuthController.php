<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->redirectUrl(url('/auth/google/callback'))
            ->redirect();
    }

    public function callback(Request $request)
    {
        $googleUser = Socialite::driver('google')
            ->redirectUrl(url('/auth/google/callback'))
            ->stateless()
            ->user();

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

            Auth::login($user);

            if ($user->esCliente()) {
                return redirect()->intended(route('portal.inicio'));
            }
            return redirect()->intended(route('panel.dashboard'));
        }

        $request->session()->put('google_register', [
            'name'        => $googleUser->name,
            'email'       => $googleUser->email,
            'avatar'      => $googleUser->avatar,
            'provider'    => 'google',
            'provider_id' => $googleUser->id,
        ]);

        return redirect()->route('register.complete');
    }
}

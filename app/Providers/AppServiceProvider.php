<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Vinculamos la interfaz con su implementación Eloquent
        // para que Laravel inyecte automáticamente el repositorio
        $this->app->bind(
            \App\Contracts\ClienteRepositoryInterface::class,
            \App\Repositories\ClienteRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ─── Rate Limiters ────────────────────────────────────────────
        // Cada limiter protege endpoints públicos contra ataques de flood.
        // Laravel responde automaticamente con 429 Too Many Requests.

        // Login: 5 intentos por minuto por IP
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Registro: 3 intentos por minuto por IP
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        // Recuperacion de contrasena: 3 solicitudes por minuto por IP
        RateLimiter::for('forgot-password', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        // Restablecer contrasena: 3 intentos por minuto por IP
        RateLimiter::for('reset-password', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        // Verificacion de correo: 2 reenvios por minuto por IP
        RateLimiter::for('verification', function (Request $request) {
            return Limit::perMinute(2)->by($request->ip());
        });
    }
}

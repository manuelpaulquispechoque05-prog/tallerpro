<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EsCliente
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->esCliente()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Acceso denegado. Se requiere rol Cliente.'], 403);
            }

            return redirect()->route('panel.dashboard')
                ->with('error', 'Esta seccion es exclusiva para clientes.');
        }

        return $next($request);
    }
}

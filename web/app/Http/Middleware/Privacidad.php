<?php

// Historia: H-11

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Privacidad
{
    public function handle(Request $request, Closure $next)
    {
        $respuesta = $next($request);
        $respuesta->headers->set('Cache-Control', 'no-store, private');
        $respuesta->headers->set('X-Content-Type-Options', 'nosniff');
        $respuesta->headers->set('X-Frame-Options', 'DENY');
        $respuesta->headers->set('Referrer-Policy', 'same-origin');
        $respuesta->headers->set('Content-Security-Policy', "default-src 'self'; style-src 'self'; img-src 'self' data:; script-src 'none'; object-src 'none'; frame-ancestors 'none'; base-uri 'self'; form-action 'self'");
        if ($request->user()) {
            Log::info('s7.consulta', ['usuario_id' => $request->user()->getKey(), 'rol' => $request->user()->rol,
                'ruta' => $request->route()?->getName(), 'estado' => $respuesta->getStatusCode()]);
        }

        return $respuesta;
    }
}

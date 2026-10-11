<?php
// Historia: H-01, H-11

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesionVigente
{
    public function handle(Request $request, Closure $next)
    {
        $inicio = $request->session()->get('inicio_sesion');
        if (! $request->user()?->activo || ! is_int($inicio) || now()->timestamp - $inicio >= 28800 || $inicio > now()->timestamp) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('aviso', 'Tu sesión ha expirado. Inicia sesión nuevamente.');
        }
        return $next($request);
    }
}

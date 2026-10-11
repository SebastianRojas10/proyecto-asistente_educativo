<?php

// Historia: H-01, H-11

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class AccesoController extends Controller
{
    public function formulario()
    {
        return view('acceso');
    }

    public function ingresar(Request $request)
    {
        $datos = $request->only('usuario', 'clave');
        $validador = Validator::make($datos, ['usuario' => 'required|string|max:80', 'clave' => 'required|string|max:256']);
        $limite = 'ingreso:'.hash('sha256', $request->ip());
        if (RateLimiter::tooManyAttempts($limite, 5)) {
            return response()->view('acceso', ['aviso' => 'Demasiados intentos. Espera un minuto e inténtalo de nuevo.'], 429);
        }
        RateLimiter::hit($limite, 60);
        if ($validador->fails()) {
            return back()->withErrors(['acceso' => 'Usuario o contraseña incorrectos.']);
        }
        $usuario = Usuario::where('nombre_usuario', $datos['usuario'])->first();
        // Hash ficticio: un usuario inexistente también ejecuta bcrypt.
        $hash = $usuario?->contrasena_hash ?? '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.';
        $valida = Hash::check($datos['clave'], $hash);
        if (! $valida || ! $usuario?->activo || ! in_array($usuario->rol, ['estudiante', 'docente', 'direccion'], true)) {
            return back()->withErrors(['acceso' => 'Usuario o contraseña incorrectos.'])->withInput(['usuario' => $datos['usuario']]);
        }
        // Sin remember ni rehash automático: la cuenta SQL solo tiene SELECT.
        Auth::login($usuario);
        $request->session()->regenerate();
        $request->session()->put('inicio_sesion', now()->timestamp);
        RateLimiter::clear($limite);
        Log::info('s7.inicio_sesion', ['usuario_id' => $usuario->getKey(), 'rol' => $usuario->rol]);

        return redirect()->route('inicio');
    }

    public function salir(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function inicio(Request $request)
    {
        return redirect()->route(match ($request->user()->rol) {
            'estudiante' => 'estudiante.reporte', 'docente' => 'docente.grupos',
            'direccion' => 'direccion.resumen', default => abort(403),
        });
    }
}

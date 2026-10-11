<?php

// Historia: H-07, H-01, H-03, H-11

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Services\Reportes;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function grupos(Request $request)
    {
        abort_unless($request->user()->rol === 'docente', 403);
        $grupos = $request->user()->gruposDocente()->where('grupo.activo', 1)->orderBy('codigo_grupo')->get();

        return view('grupos', compact('grupos'));
    }

    public function reporte(Request $request, Reportes $reportes, string $grupo, ?string $simulacro = null)
    {
        abort_unless($request->user()->rol === 'docente', 403);
        $grupo = Grupo::where('codigo_grupo', $grupo)->where('activo', 1)->firstOrFail();
        abort_unless($request->user()->gruposDocente()->where('grupo.grupo_id', $grupo->getKey())->exists(), 403);
        $disponibles = $grupo->simulacros()->orderByDesc('fecha_aplicacion')->orderByDesc('simulacro.simulacro_id')->get();
        if ($simulacro !== null) {
            abort_unless(ctype_digit($simulacro) && strlen($simulacro) <= 18, 404);
            $seleccionado = $disponibles->firstWhere('simulacro_id', $simulacro);
            abort_unless($seleccionado, 404);
        } else {
            $seleccionado = $disponibles->first();
        }
        $usuarios = $grupo->estudiantes()->pluck('usuario.usuario_id')->map(fn ($id) => (int) $id)->all();
        $resultado = $seleccionado ? $reportes->calcular($seleccionado, $usuarios) : null;
        if ($resultado) {
            usort($resultado['temas'], fn ($a, $b) => (($b['error'] ?? -1) <=> ($a['error'] ?? -1)) ?: strcmp($a['nombre'], $b['nombre']));
        }

        return view('grupal', compact('grupo', 'disponibles', 'seleccionado', 'resultado'));
    }
}

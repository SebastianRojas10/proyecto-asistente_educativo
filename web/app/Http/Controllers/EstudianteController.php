<?php

// Historia: H-04, H-03, H-01, H-11

namespace App\Http\Controllers;

use App\Models\Simulacro;
use App\Services\CalculoResultados;
use App\Services\Reportes;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function reporte(Request $request, Reportes $reportes, ?string $simulacro = null)
    {
        abort_unless($request->user()->rol === 'estudiante', 403);
        $usuario = $request->user();
        $disponibles = Simulacro::whereHas('preguntas.respuestas', fn ($q) => $q->where('usuario_id', $usuario->getKey()))
            ->orderByDesc('fecha_aplicacion')->orderByDesc('simulacro_id')->get();
        if ($simulacro !== null) {
            abort_unless(ctype_digit($simulacro) && strlen($simulacro) <= 18, 404);
            $seleccionado = $disponibles->firstWhere('simulacro_id', $simulacro);
            abort_unless($seleccionado, 404);
        } else {
            $seleccionado = $disponibles->first();
        }
        $resultado = $seleccionado ? $reportes->calcular($seleccionado, [(int) $usuario->getKey()]) : null;
        if ($resultado) {
            $resultado['temas'] = collect($resultado['temas'])->sortBy([
                ['aciertos', 'asc'], ['incorrectas', 'desc'], ['nombre', 'asc'],
            ])->values()->all();
            $resultado['global'] = CalculoResultados::porcentaje($resultado['correctas'], $resultado['preguntas']) ?? 0;
        }

        return view('estudiante', compact('usuario', 'disponibles', 'seleccionado', 'resultado'));
    }
}

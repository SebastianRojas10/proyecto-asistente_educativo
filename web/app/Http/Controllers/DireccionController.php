<?php
// Historia: H-09, H-01, H-11

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Simulacro;
use App\Services\Reportes;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    public function resumen(Request $request, Reportes $reportes, ?string $simulacro = null)
    {
        abort_unless($request->user()->rol === 'direccion', 403);
        $grupos = Grupo::where('activo', 1)->where('nivel', '5.º secundaria')->with(['simulacros', 'estudiantes'])->get();
        $ids = $grupos->flatMap(fn ($g) => $g->simulacros->pluck('simulacro_id'))->unique();
        $disponibles = Simulacro::whereIn('simulacro_id', $ids)->orderByDesc('fecha_aplicacion')->orderByDesc('simulacro_id')->get();
        if ($simulacro !== null) {
            abort_unless(ctype_digit($simulacro) && strlen($simulacro) <= 18, 404);
            $seleccionado = $disponibles->firstWhere('simulacro_id', $simulacro);
            abort_unless($seleccionado, 404);
        } else {
            $seleccionado = $disponibles->first();
        }
        $filas = [];
        $usuarios = [];
        foreach ($grupos as $grupo) {
            if (! $seleccionado || ! $grupo->simulacros->contains('simulacro_id', $seleccionado->getKey())) {
                continue;
            }
            $idsUsuario = $grupo->estudiantes->pluck('usuario_id')->map(fn ($id) => (int) $id)->all();
            $r = $reportes->calcular($seleccionado, $idsUsuario);
            if ($r['participantes']) {
                $filas[] = ['grupo' => $grupo->codigo_grupo, 'participantes' => $r['participantes']];
                $usuarios = array_merge($usuarios, $idsUsuario);
            }
        }
        $excluidos = $grupos->count() - count($filas);
        $resultado = $seleccionado ? $reportes->calcular($seleccionado, array_values(array_unique($usuarios))) : null;
        if ($resultado) {
            usort($resultado['temas'], fn ($a, $b) => (($b['error_institucional'] ?? -1) <=> ($a['error_institucional'] ?? -1)) ?: strcmp($a['nombre'], $b['nombre']));
        }
        return view('institucional', compact('disponibles', 'seleccionado', 'resultado', 'filas', 'excluidos'));
    }
}

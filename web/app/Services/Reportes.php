<?php
// Historia: H-03, H-04, H-07, H-09, H-11

namespace App\Services;

use App\Models\Simulacro;
use App\Models\Tema;
use Illuminate\Support\Facades\Log;

class Reportes
{
    public function __construct(private CalculoResultados $calculo) {}

    public function calcular(Simulacro $simulacro, array $usuarios): array
    {
        $preguntas = $simulacro->preguntas()->with(['tema', 'respuestas' => fn ($q) => $q->whereIn('usuario_id', $usuarios)])->get();
        $entrada = $preguntas->map(fn ($p) => ['id' => $p->pregunta_id, 'tema_id' => $p->tema_id,
            'tema' => $p->tema->nombre, 'correcta' => $p->opcion_correcta])->all();
        $respuestas = $preguntas->flatMap(fn ($p) => $p->respuestas->map(fn ($r) => [
            'usuario_id' => (int) $r->usuario_id, 'pregunta_id' => (int) $r->pregunta_id, 'opcion' => $r->opcion_seleccionada,
        ]))->all();
        $resumen = $this->calculo->resumir($entrada, $respuestas, $usuarios);
        $resumen['excluidos'] = Tema::whereNotIn('tema_id', $preguntas->pluck('tema_id')->unique())->count();
        if ($resumen['omitidos']) {
            Log::warning('s7.datos_inconsistentes', ['cantidad' => $resumen['omitidos']]);
        }
        return $resumen;
    }
}

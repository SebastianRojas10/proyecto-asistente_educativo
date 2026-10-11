<?php
// Historia: H-03, H-04, H-07, H-09

namespace App\Services;

class CalculoResultados
{
    public static function porcentaje(int $parte, int $total, int $decimales = 1): ?float
    {
        return $total > 0 ? round($parte * 100 / $total, $decimales) : null;
    }

    /** Datos planos para verificar las fórmulas sin conexión SQL. */
    public function resumir(array $preguntas, array $respuestas, array $usuarios): array
    {
        $opciones = ['A', 'B', 'C', 'D', 'E'];
        $porPregunta = [];
        $temas = [];
        $omitidos = 0;
        foreach ($preguntas as $p) {
            if (! in_array($p['correcta'], $opciones, true)) {
                $omitidos++;
                continue;
            }
            $porPregunta[$p['id']] = $p;
            $temas[$p['tema_id']] ??= ['nombre' => $p['tema'], 'preguntas' => 0, 'correctas' => 0, 'incorrectas' => 0, 'respondidas' => 0];
            $temas[$p['tema_id']]['preguntas']++;
        }
        $participantes = [];
        $vistos = [];
        foreach ($respuestas as $r) {
            $clave = $r['usuario_id'].':'.$r['pregunta_id'];
            if (! isset($porPregunta[$r['pregunta_id']]) || ! in_array($r['usuario_id'], $usuarios, true)
                || ! in_array($r['opcion'], $opciones, true) || isset($vistos[$clave])) {
                $omitidos++;
                continue;
            }
            $vistos[$clave] = true;
            $participantes[$r['usuario_id']] = true;
            $p = $porPregunta[$r['pregunta_id']];
            $temas[$p['tema_id']]['respondidas']++;
            $temas[$p['tema_id']][$p['correcta'] === $r['opcion'] ? 'correctas' : 'incorrectas']++;
        }
        $n = count($participantes);
        foreach ($temas as &$tema) {
            $tema['esperadas'] = $tema['preguntas'] * $n;
            $tema['sin_responder'] = max(0, $tema['esperadas'] - $tema['respondidas']);
            $tema['aciertos'] = self::porcentaje($tema['correctas'], $tema['esperadas']) ?? 0.0;
            $tema['error'] = self::porcentaje($tema['incorrectas'], $tema['respondidas']);
            $tema['error_institucional'] = self::porcentaje($tema['incorrectas'], $tema['respondidas'], 2);
        }
        unset($tema);
        return ['temas' => array_values($temas), 'participantes' => $n, 'preguntas' => count($porPregunta),
            'correctas' => array_sum(array_column($temas, 'correctas')), 'omitidos' => $omitidos];
    }
}

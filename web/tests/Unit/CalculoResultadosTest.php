<?php

// Historia: H-03, H-04, H-07, H-09

namespace Tests\Unit;

use App\Services\CalculoResultados;
use PHPUnit\Framework\TestCase;

class CalculoResultadosTest extends TestCase
{
    public function test_precision_y_denominador_cero(): void
    {
        $this->assertSame(33.3, CalculoResultados::porcentaje(1, 3));
        $this->assertSame(33.33, CalculoResultados::porcentaje(1, 3, 2));
        $this->assertNull(CalculoResultados::porcentaje(0, 0));
    }

    public function test_omisiones_no_suman_aciertos_y_tema_sin_respuestas_tiene_cero(): void
    {
        $preguntas = [['id' => 1, 'tema_id' => 1, 'tema' => 'A', 'correcta' => 'A'], ['id' => 2, 'tema_id' => 2, 'tema' => 'B', 'correcta' => 'C']];
        $r = (new CalculoResultados)->resumir($preguntas, [['usuario_id' => 1, 'pregunta_id' => 1, 'opcion' => 'A']], [1]);
        $this->assertSame(1, $r['correctas']);
        $this->assertSame(0.0, $r['temas'][1]['aciertos']);
        $this->assertNull($r['temas'][1]['error']);
        $this->assertSame(1, $r['temas'][1]['sin_responder']);
    }

    public function test_datos_invalidos_duplicados_y_ajenos_se_omiten(): void
    {
        $preguntas = [['id' => 1, 'tema_id' => 1, 'tema' => 'A', 'correcta' => 'A']];
        $respuestas = [['usuario_id' => 1, 'pregunta_id' => 1, 'opcion' => 'A'], ['usuario_id' => 1, 'pregunta_id' => 1, 'opcion' => 'A'],
            ['usuario_id' => 2, 'pregunta_id' => 1, 'opcion' => 'A'], ['usuario_id' => 1, 'pregunta_id' => 99, 'opcion' => 'A'],
            ['usuario_id' => 1, 'pregunta_id' => 1, 'opcion' => 'Z']];
        $r = (new CalculoResultados)->resumir($preguntas, $respuestas, [1]);
        $this->assertSame(4, $r['omitidos']);
        $this->assertSame(1, $r['participantes']);
        $this->assertSame(100.0, $r['temas'][0]['aciertos']);
    }
}

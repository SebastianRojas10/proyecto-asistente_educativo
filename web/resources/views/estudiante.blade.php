{{-- Historia: H-04, H-03, H-11 --}}
@extends('layouts.app')
@section('titulo', 'Mi reporte')
@section('contenido')
<div class="encabezado"><div><p class="etiqueta">MI APRENDIZAJE</p><h1>Mi reporte de simulacro</h1><p class="muted">Reconoce tus avances y los temas que necesitan más práctica.</p></div><span class="codigo">{{ $usuario->codigo_anonimo }}</span></div>
@if(!$seleccionado || !$resultado['participantes'])
    <section class="panel vacio"><span class="simbolo" aria-hidden="true">○</span><h2>Aún no hay resultados</h2><p>No existen resultados disponibles para tu cuenta.</p><p class="muted">Podrás consultar tu reporte cuando se registren respuestas válidas.</p></section>
@else
    <nav class="selector" aria-label="Elegir simulacro">@foreach($disponibles as $s)<a @class(['opcion', 'activa' => $s->simulacro_id === $seleccionado->simulacro_id]) href="{{ route('estudiante.reporte', $s->simulacro_id) }}" @if($s->simulacro_id === $seleccionado->simulacro_id) aria-current="page" @endif>{{ $s->nombre }}</a>@endforeach</nav>
    <div class="titulo-reporte"><div><h2>{{ $seleccionado->nombre }}</h2><p class="muted">Aplicado el {{ $seleccionado->fecha_aplicacion->format('d/m/Y') }}</p></div><span class="insignia">Reporte personal</span></div>
    <section class="metricas" aria-label="Resumen"><div class="metrica principal"><span>Aciertos globales</span><strong>{{ number_format($resultado['global'], 1) }}<small> %</small></strong><span>Sobre todas las preguntas</span></div><div class="metrica"><span>Respuestas correctas</span><strong>{{ $resultado['correctas'] }}<small> / {{ $resultado['preguntas'] }}</small></strong><span>Tu puntaje en este simulacro</span></div><div class="metrica"><span>Temas por reforzar</span><strong>{{ collect($resultado['temas'])->filter(fn($t) => $t['incorrectas'] + $t['sin_responder'] > 0)->count() }}</strong><span>Con errores o preguntas sin responder</span></div></section>
    <section class="panel"><div class="seccion-titulo"><div><h2>Tu desempeño por tema</h2><p class="muted">De menor a mayor porcentaje de aciertos.</p></div><span class="insignia neutra">{{ count($resultado['temas']) }} temas</span></div>
    <div class="tabla-scroll"><table><caption class="sr-only">Resultados del estudiante por tema</caption><thead><tr><th scope="col">Tema</th><th scope="col">Aciertos</th><th scope="col">Correctas</th><th scope="col">Errores</th><th scope="col">Sin responder</th></tr></thead><tbody>
    @foreach($resultado['temas'] as $t)<tr><th scope="row">{{ $t['nombre'] }}</th><td><div class="porcentaje"><meter min="0" max="100" value="{{ $t['aciertos'] }}" aria-label="Aciertos en {{ $t['nombre'] }}"></meter><b>{{ number_format($t['aciertos'], 1) }} %</b></div></td><td>{{ $t['correctas'] }} / {{ $t['preguntas'] }}</td><td>{{ $t['incorrectas'] }}</td><td>{{ $t['sin_responder'] }}</td></tr>@endforeach
    </tbody></table></div><p class="nota">Temas excluidos por no tener preguntas: {{ $resultado['excluidos'] }}. Registros inconsistentes omitidos: {{ $resultado['omitidos'] }}.</p></section>
    <p class="orientacion">Usa este reporte como punto de partida para conversar con tu docente. Los resultados describen este simulacro; no determinan tu capacidad.</p>
@endif
@endsection

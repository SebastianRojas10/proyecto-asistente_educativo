{{-- Historia: H-09, H-11 --}}
@extends('layouts.app')
@section('titulo', 'Resumen institucional')
@section('contenido')
<div class="encabezado"><div><p class="etiqueta">MIRADA INSTITUCIONAL</p><h1>Resultados de quinto de secundaria</h1><p class="muted">Una visión conjunta de los temas que necesitan refuerzo.</p></div></div>
<nav class="selector" aria-label="Elegir simulacro">@foreach($disponibles as $s)<a @class(['opcion', 'activa' => $seleccionado?->simulacro_id === $s->simulacro_id]) href="{{ route('direccion.resumen', $s->simulacro_id) }}" @if($seleccionado?->simulacro_id === $s->simulacro_id) aria-current="page" @endif>{{ $s->nombre }}</a>@endforeach</nav>
@if(!$seleccionado || !$resultado['participantes'])
<section class="panel vacio"><span class="simbolo" aria-hidden="true">○</span><h2>Sin resultados disponibles</h2><p>No existen resultados de quinto de secundaria para esta selección.</p><p class="muted">Selecciona otro simulacro de la lista.</p></section>
@else
<div class="titulo-reporte"><div><h2>{{ $seleccionado->nombre }}</h2><p class="muted">Aplicado el {{ $seleccionado->fecha_aplicacion->format('d/m/Y') }}</p></div><span class="insignia">Datos agregados</span></div>
<section class="metricas" aria-label="Resumen institucional"><div class="metrica principal"><span>Estudiantes incluidos</span><strong>{{ $resultado['participantes'] }}</strong><span>Sin identificación individual</span></div><div class="metrica"><span>Grupos con resultados</span><strong>{{ count($filas) }}</strong><span>{{ collect($filas)->pluck('grupo')->join(' · ') }}</span></div><div class="metrica"><span>Grupos sin resultados</span><strong>{{ $excluidos }}</strong><span>Excluidos de los cálculos</span></div></section>
<section class="panel"><div class="seccion-titulo"><div><h2>Prioridades de refuerzo institucional</h2><p class="muted">Porcentaje de error agregado por tema, de mayor a menor.</p></div></div>@include('partials.tabla-grupal', ['decimales' => 2])<p class="nota">Porcentaje = errores / respuestas válidas × 100. Las omisiones se contabilizan separadamente. Temas sin preguntas: {{ $resultado['excluidos'] }}. Registros inconsistentes omitidos: {{ $resultado['omitidos'] }}.</p></section>
<p class="orientacion">Este perfil muestra únicamente resultados agregados. El detalle individual corresponde al estudiante y a los permisos docentes definidos para otras etapas.</p>
@endif
@endsection

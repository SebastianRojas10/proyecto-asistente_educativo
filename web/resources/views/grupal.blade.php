{{-- Historia: H-07, H-03, H-11 --}}
@extends('layouts.app')
@section('titulo', 'Reporte grupal')
@section('contenido')
<a class="volver" href="{{ route('docente.grupos') }}">← Volver a mis grupos</a>
<div class="encabezado"><div><p class="etiqueta">ACOMPAÑAMIENTO DOCENTE</p><h1>Reporte de {{ $grupo->nivel }} · {{ $grupo->seccion }}</h1><p class="muted">Identifica las dificultades compartidas antes de la próxima clase.</p></div><span class="codigo">{{ $grupo->codigo_grupo }}</span></div>
<nav class="selector" aria-label="Elegir simulacro">@foreach($disponibles as $s)<a @class(['opcion', 'activa' => $seleccionado?->simulacro_id === $s->simulacro_id]) href="{{ route('docente.reporte', [$grupo->codigo_grupo, $s->simulacro_id]) }}" @if($seleccionado?->simulacro_id === $s->simulacro_id) aria-current="page" @endif>{{ $s->nombre }}</a>@endforeach</nav>
@if(!$seleccionado || !$resultado['participantes'])
<section class="panel vacio"><span class="simbolo" aria-hidden="true">○</span><h2>Sin resultados para esta selección</h2><p>No existen resultados disponibles para este grupo en el simulacro seleccionado.</p><p class="muted">Selecciona otro simulacro de la lista, si está disponible.</p></section>
@else
<div class="titulo-reporte"><div><h2>{{ $seleccionado->nombre }}</h2><p class="muted">Aplicado el {{ $seleccionado->fecha_aplicacion->format('d/m/Y') }}</p></div><span class="insignia">Vista del grupo</span></div>
<section class="metricas" aria-label="Resumen del grupo"><div class="metrica principal"><span>Estudiantes incluidos</span><strong>{{ $resultado['participantes'] }}</strong><span>Con al menos una respuesta válida</span></div><div class="metrica"><span>Temas evaluados</span><strong>{{ count($resultado['temas']) }}</strong><span>Ordenados por porcentaje de error</span></div><div class="metrica"><span>Preguntas del simulacro</span><strong>{{ $resultado['preguntas'] }}</strong><span>Por estudiante</span></div></section>
<section class="panel"><div class="seccion-titulo"><div><h2>¿Qué debemos reforzar?</h2><p class="muted">Los temas con mayor porcentaje de error aparecen primero.</p></div></div>
@include('partials.tabla-grupal', ['decimales' => 1])
<p class="nota">El porcentaje de error usa las respuestas válidas recibidas. Las preguntas sin responder se muestran por separado. Temas sin preguntas: {{ $resultado['excluidos'] }}. Registros inconsistentes omitidos: {{ $resultado['omitidos'] }}.</p></section>
@endif
@endsection

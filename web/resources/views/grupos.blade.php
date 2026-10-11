{{-- Historia: H-07, H-01 --}}
@extends('layouts.app')
@section('titulo', 'Mis grupos')
@section('contenido')
<div class="encabezado"><div><p class="etiqueta">ACOMPAÑAMIENTO DOCENTE</p><h1>Mis grupos</h1><p class="muted">Elige un grupo para revisar qué temas conviene reforzar en clase.</p></div></div>
<div class="grupos">@forelse($grupos as $g)<section class="panel grupo"><p class="etiqueta">{{ $g->codigo_grupo }}</p><h2>{{ $g->nivel }} · {{ $g->seccion }}</h2><p class="muted">Resultados agregados por tema y simulacro.</p><a class="boton" href="{{ route('docente.reporte', $g->codigo_grupo) }}">Ver reportes <span aria-hidden="true">→</span></a></section>@empty<section class="panel vacio"><h2>Sin grupos asignados</h2><p>No hay grupos activos asociados a tu cuenta.</p></section>@endforelse</div>
@endsection

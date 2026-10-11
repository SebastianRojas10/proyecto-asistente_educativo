{{-- Historia: H-01, H-11 --}}
@extends('layouts.app')
@section('titulo', 'Iniciar sesión')
@section('contenido')
<div class="entrada">
    <section class="introduccion"><p class="etiqueta">APRENDE DE CADA SIMULACRO</p><h1>Entiende tus resultados.<br>Prepara tu siguiente paso.</h1><p>Consulta tu desempeño por tema y descubre dónde concentrar el refuerzo antes de la próxima evaluación.</p>
    <div class="pasos"><p><b>01</b> Revisa tus aciertos y errores</p><p><b>02</b> Identifica los temas por reforzar</p><p><b>03</b> Conversa sobre tus avances en clase</p></div><p class="nota">Cada perfil accede únicamente a los resultados que le corresponden.</p></section>
    <section class="panel acceso"><p class="etiqueta">BIENVENIDO</p><h2>Ingresa a tus reportes</h2><p class="muted">Utiliza la cuenta que te asignó tu equipo.</p>
    @if($errors->any())<p role="alert" class="aviso error">{{ $errors->first() }}</p>@endif
    @if($aviso ?? session('aviso'))<p role="alert" class="aviso">{{ $aviso ?? session('aviso') }}</p>@endif
    <form action="{{ route('ingresar') }}" method="post">@csrf
        <label for="usuario">Usuario</label><input id="usuario" name="usuario" value="{{ old('usuario') }}" maxlength="80" autocomplete="username" required>
        <label for="clave">Contraseña</label><input id="clave" name="clave" type="password" maxlength="256" autocomplete="current-password" required>
        <button type="submit" class="boton ancho">Iniciar sesión <span aria-hidden="true">→</span></button>
    </form><p class="nota">Estudiantes · Docentes · Dirección</p></section>
</div>
@endsection

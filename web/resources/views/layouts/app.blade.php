{{-- Historia: H-01, H-04, H-07, H-09, H-11 --}}
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Resultados') · Asistente CNI</title>
    <link rel="stylesheet" href="{{ asset('css/s7.css') }}">
</head>
<body>
<a class="saltar" href="#contenido">Saltar al contenido</a>
<header class="cabecera">
    <a class="marca" href="{{ route('inicio') }}"><span class="monograma">CNI</span><span>Asistente educativo<small>Simulacros de admisión</small></span></a>
    @auth
        <nav aria-label="Principal"><a href="{{ route('inicio') }}">Mis reportes</a><span class="rol">{{ ucfirst(auth()->user()->rol) }}</span>
        <form action="{{ route('salir') }}" method="post">@csrf<button class="salir" type="submit">Cerrar sesión</button></form></nav>
    @endauth
</header>
<main id="contenido" class="contenedor">@yield('contenido')</main>
<footer class="pie"><span>Colegio Nacional de Ica · Preparación para la admisión</span><span>Demostración con datos ficticios</span></footer>
</body>
</html>

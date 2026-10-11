<?php

// Historia: H-01, H-04, H-07, H-09, H-11

use App\Http\Middleware\Privacidad;
use App\Http\Middleware\SesionVigente;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->web(append: [Privacidad::class]);
        $middleware->alias(['vigente' => SesionVigente::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->dontFlash(['clave', 'password', 'password_confirmation', 'current_password']);
        $exceptions->report(function (QueryException $e) {
            Log::error('s7.base_no_disponible', ['codigo' => $e->getCode()]);

            return false;
        });
        $exceptions->render(fn (QueryException $e) => response()->view('errors.503', [], 503));
    })->create();

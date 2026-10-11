<?php
// Historia: H-01, H-04, H-07, H-09, H-11

use App\Http\Controllers\AccesoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\DireccionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/inicio');
Route::get('/ingresar', [AccesoController::class, 'formulario'])->name('login');
Route::post('/ingresar', [AccesoController::class, 'ingresar'])->name('ingresar');
Route::post('/salir', [AccesoController::class, 'salir'])->name('salir');
Route::middleware(['auth', 'vigente'])->group(function () {
    Route::get('/inicio', [AccesoController::class, 'inicio'])->name('inicio');
    Route::get('/estudiante/reporte/{simulacro?}', [EstudianteController::class, 'reporte'])
        ->where('simulacro', '[A-Za-z0-9-]{1,40}')->name('estudiante.reporte');
    Route::get('/docente/grupos', [DocenteController::class, 'grupos'])->name('docente.grupos');
    Route::get('/docente/grupos/{grupo}/simulacros/{simulacro?}', [DocenteController::class, 'reporte'])
        ->where(['grupo' => '[A-Za-z0-9-]{1,30}', 'simulacro' => '[A-Za-z0-9-]{1,40}'])->name('docente.reporte');
    Route::get('/direccion/resumen/{simulacro?}', [DireccionController::class, 'resumen'])
        ->where('simulacro', '[A-Za-z0-9-]{1,40}')->name('direccion.resumen');
});

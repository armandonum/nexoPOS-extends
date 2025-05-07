
<?php
use Illuminate\Support\Facades\Route;
use Modules\Ofertas\Http\Controllers\MiModuloController;

Route::get('dashboard/Ofertas', [MiModuloController::class, 'index']);

Route::get('/ofertas/crear', [MiModuloController::class, 'formularioCrear'])->name('ofertas.crear');

Route::post('/ofertas/guardar-seleccion', [MiModuloController::class, 'guardarSeleccion'])->name('ofertas.guardarSeleccion');
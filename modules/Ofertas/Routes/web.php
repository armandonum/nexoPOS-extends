
<?php
use Illuminate\Support\Facades\Route;
use Modules\Ofertas\Http\Controllers\OfertaController;
use Modules\Ofertas\Http\Controllers\MiModuloController;

Route::get('dashboard/Ofertas', [MiModuloController::class, 'index']);

// Route::get('/ofertas/crear', [MiModuloController::class, 'formularioCrear'])->name('ofertas.crear');
// Route::post('/ofertas/guardar-seleccion', [MiModuloController::class, 'guardarSeleccion'])->name('ofertas.guardarSeleccion');
Route::get('/ofertas/crear', [OfertaController::class, 'create'])->name('ofertas.crear');
Route::post('/ofertas', [OfertaController::class, 'store'])->name('ofertas.store');



// ENPOINTS PARA MOSTRAR LISTA DE OFERTAS DE OFERTAS DISPONIBLES
Route::get('/api/ofertas/activas', [OfertaController::class, 'getActiveOffers']);
// Route::prefix('api')->group(function() {
//     Route::get('/ofertas/activas', [OfertaController::class, 'getActiveOffers']);
// });
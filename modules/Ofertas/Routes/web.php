
<?php
use Illuminate\Support\Facades\Route;
use Modules\Ofertas\Http\Controllers\OfertaController;
use Modules\Ofertas\Http\Controllers\TipoOfertaController;
use Modules\Ofertas\Http\Controllers\MiModuloController;

Route::get('dashboard/Ofertas', [MiModuloController::class, 'index']);
//Ofertas
Route::get('/ofertas/crear', [OfertaController::class, 'create'])->name('ofertas.crear');
Route::post('/ofertas', [OfertaController::class, 'store'])->name('ofertas.store');




// ENPOINTS PARA MOSTRAR LISTA DE OFERTAS DE OFERTAS DISPONIBLES
Route::get('/api/ofertas/activas', [OfertaController::class, 'getActiveOffers']);
// Route::prefix('api')->group(function() {
//     Route::get('/ofertas/activas', [OfertaController::class, 'getActiveOffers']);
// });
//Tipo Ofertas

Route::get('/tipo_ofertas/crear', [TipoOfertaController::class, 'cargarFormularioTipoOferta'])->name('tipo_ofertas.crear');
Route::post('/tipo_ofertas', [TipoOfertaController::class, 'almacenarTipoOferta'])->name('tipo_ofertas.store');

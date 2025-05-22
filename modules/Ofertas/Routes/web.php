
<?php
use Illuminate\Support\Facades\Route;
use Modules\Ofertas\Http\Controllers\OfertaController;
use Modules\Ofertas\Http\Controllers\TipoOfertaController;
use Modules\Ofertas\Http\Controllers\MiModuloController;

Route::get('dashboard/Ofertas', [MiModuloController::class, 'index']);

Route::get('/ofertas/crear', [OfertaController::class, 'create'])->name('ofertas.crear');
Route::post('/ofertas', [OfertaController::class, 'store'])->name('ofertas.store');


Route::get('/api/ofertas/activas', [OfertaController::class, 'getActiveOffers']);

Route::get('/tipo_ofertas/crear', [TipoOfertaController::class, 'cargarFormularioTipoOferta'])->name('tipo_ofertas.crear');
Route::post('/tipo_ofertas', [TipoOfertaController::class, 'almacenarTipoOferta'])->name('tipo_ofertas.store');


Route::post('/{id}/duplicate', [OfertaController::class, 'duplicate'])->name('ofertas.duplicate');


Route::get('/ofertas_list', [OfertaController::class, 'index'])->name('ofertas.index');
Route::put('/ofertas/{id}', [OfertaController::class, 'updateEstate'])->name('ofertas.updateState');
Route::put('/dashboard/Ofertas/{id}', [OfertaController::class, 'update'])->name('ofertas.update');

Route::get('/dashboard/Ofertas/{id}/editar', [OfertaController::class, 'edit'])->name('ofertas.editar');
Route::delete('/ofertas/{id}', [OfertaController::class, 'destroy'])->name('ofertas.destroy');



Route::get('/tipo_ofertas/crear', [TipoOfertaController::class, 'cargarFormularioTipoOferta'])->name('tipo_ofertas.crear');
Route::post('/tipo_ofertas', [TipoOfertaController::class, 'almacenarTipoOferta'])->name('tipo_ofertas.store');



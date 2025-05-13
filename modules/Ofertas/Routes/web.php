
<?php
use Illuminate\Support\Facades\Route;
use Modules\Ofertas\Http\Controllers\OfertaController;
use Modules\Ofertas\Http\Controllers\TipoOfertaController;

Route::get('dashboard/Ofertas', [MiModuloController::class, 'index']);
//Ofertas
Route::get('/ofertas/crear', [OfertaController::class, 'create'])->name('ofertas.crear');
Route::post('/ofertas', [OfertaController::class, 'store'])->name('ofertas.store');
//Tipo Ofertas

<?php 

use Illuminate\Support\Facades\Route;
use Modules\Test\Http\Controllers\MimoduloController;

Route::get('dashboard/hello_world', [MiModuloController::class, 'hello']);

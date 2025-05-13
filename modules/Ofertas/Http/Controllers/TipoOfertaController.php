<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Ofertas\Models\TipoOferta;

class TipoOfertaController extends Controller
{

    public static function obtenerTodosTipoOferta()
    {
        $tiposOfertas = TipoOferta::all();
        return $tiposOfertas;
    }
}
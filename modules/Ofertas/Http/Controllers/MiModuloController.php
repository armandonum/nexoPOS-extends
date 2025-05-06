<?php

/**
 * Ofertas Controller
 * @since 1.0
 * @package modules/Ofertas
**/

namespace Modules\Ofertas\Http\Controllers;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;

class MiModuloController extends Controller
{
    /**
     * Main Page
     * @since 1.0
    **/
    public function index()
    {
        return view( 'Ofertas::index',[
            'title' => 'Ofertas',
            'description' => 'modulo de ofertas'
        ] );
    }

    public function helloWorld()
    {
        return view( 'Ofertas::helloWorld' );
    }
}

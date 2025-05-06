<?php

/**
 * test Controller
 * @since 1.0
 * @package modules/Test
**/

namespace Modules\Test\Http\Controllers;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;

class MimoduloController extends Controller
{
    /**
     * Main Page
     * @since 1.0
    **/
    public function index()
    {
        return $this->view( 'Test::index' );
    }

    public function hello()
    {
        return $this->view( 'Test::hello' );
    }
}

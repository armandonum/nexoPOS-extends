<?php
namespace Modules\Ofertas;

use Illuminate\Support\Facades\Event;
use App\Services\Module;

class OfertasModule extends Module
{
    public function __construct()
    {
        parent::__construct( __FILE__ );
    }
}
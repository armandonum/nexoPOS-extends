<?php
namespace Modules\Test;

use Illuminate\Support\Facades\Event;
use App\Services\Module;

class TestModule extends Module
{
    public function __construct()
    {
        parent::__construct( __FILE__ );
    }
}
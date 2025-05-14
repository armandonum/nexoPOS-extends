<?php

namespace Tests\Unit\Modules\Ofertas\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Modules\Ofertas\Http\Controllers\MiModuloController;
use App\Http\Controllers\Dashboard\ProductsController;
use Mockery;
class MiModuloControllerTest extends TestCase
{
    use RefreshDatabase; // Refresca la base de datos para cada prueba

    protected
     function setUp(): void
    {
        parent::setUp();
        // Configuraciones adicionales, como mockear dependencias
    }

    protected function tearDown(): void
    {
        Mockery::close(); // Cierra los mocks de Mockery
        parent::tearDown();
    }

    public function testIndexReturnsCorrectView()
{
    $response = $this->get(action([MiModuloController::class, 'index']));

    $response->assertStatus(200)
             ->assertViewIs('Ofertas::index')
             ->assertViewHas('title', 'Ofertas')
             ->assertViewHas('description', 'modulo de ofertas');
}
}
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class MiModuloControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    /** @test */
    public function index_view_is_accessible(): void
    {
        $response = $this->get(route('ofertas.index')); // Ajusta la ruta si es diferente

        $response->assertStatus(200);
        $response->assertViewIs('Ofertas::index');
        $response->assertViewHas('title', 'Ofertas');
    }

    /** @test */
    public function hello_world_view_is_accessible()
    {
        $response = $this->get(route('ofertas.hello')); // Ajusta la ruta si es diferente

        $response->assertStatus(200);
        $response->assertViewIs('Ofertas::helloWorld');
    }

    public function test_formulario_crear_muestra_vista_correcta()
    {
        Session::put('selected_products', [1, 2]);

        // Puedes mockear la llamada a obtenerProductos() si es necesario
        // O simplemente verificar que no falle
        $response = $this->get(route('ofertas.crear')); // Ajusta la ruta

        $response->assertStatus(200);
        $response->assertViewIs('Ofertas::crear_oferta');
        $response->assertViewHas('selectedProducts');
    }

    public function test_guardar_seleccion_funciona_con_productos()
    {
        $response = $this->post(route('ofertas.guardar-seleccion'), [
            'product_ids' => [1, 2, 3],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'selected_products' => [1, 2, 3],
        ]);

        $this->assertEquals([1, 2, 3], session('selected_products'));
    }

    public function test_guardar_seleccion_falla_sin_productos()
    {
        $response = $this->post('/ofertas/guardar-seleccion', []);

        $response->assertStatus(400);
        $response->assertJson([
            'error' => 'No se seleccionaron productos.',
        ]);
    }

}

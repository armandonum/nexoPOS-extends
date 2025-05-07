<?php


namespace Modules\Ofertas\Http\Controllers;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\ProductsController;

class MiModuloController extends Controller
{
    private $selectedProducts = [];

    public function index()
    {
        return view('Ofertas::index', [
            'title' => 'Ofertas',
            'description' => 'modulo de ofertas'
        ]);
    }

    public function helloWorld()
    {
        return view('Ofertas::helloWorld');
    }

    public function formularioCrear()
    {
        return view('Ofertas::crear_oferta', [
            'products' => $this->obtenerProductos()
        ]);
    }

    public static function obtenerProductos() {
        $productos = app(ProductsController::class)->getProduts();
        return $productos;
    }

    public function guardarSeleccion()
    {
        $productIds = request()->input('product_ids', []);

        if (empty($productIds)) {
            return response()->json(['error' => 'No se seleccionaron productos.'], 400);
        }

        $this->selectedProducts = array_merge($this->selectedProducts, $productIds);
        session()->put('selected_products', $this->selectedProducts);

        return response()->json([
            'success' => true,
            'selected_products' => $this->selectedProducts
        ]);
    }
}
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
            'title' => 'Crear Oferta',
            'description' => 'Crear una nueva oferta',
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







    
    public function mostrarSeleccionados()
    {
        $productIds = session('selected_products', []);
        
        if (empty($productIds)) {
            return redirect()->route('ofertas.crear')->with('error', 'No hay productos seleccionados.');
        }
    
        $todosProductos = collect(self::obtenerProductos());
        $productosSeleccionados = $todosProductos->whereIn('id', $productIds);
        
        return view('Ofertas::mostrar_seleccionados', [
            'title' => 'Productos Seleccionados',
            'description' => 'Listado de productos incluidos en la oferta',
            'selectedProducts' => $productosSeleccionados
        ]);
    }
    
    public function guardarYRedirigir()
{
    $productIds = request()->input('product_ids', []);

    if (empty($productIds)) {
        return redirect()->back()->with('error', 'No se seleccionaron productos.');
    }

    session()->put('selected_products', $productIds);

    return redirect()->route('ofertas.mostrarSeleccionados');
}
}
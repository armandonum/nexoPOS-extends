<?php

namespace Modules\Ofertas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Ofertas\Models\Oferta; // Asegúrate de usar el namespace del módulo
use App\Models\Product; // Asegúrate de usar el namespace del modelo Product

class OfertaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $products = app('Modules\Ofertas\Http\Controllers\MiModuloController')->obtenerProductos();
        $products = Product::all(); // Obtener todos los productos de la base de datos
        $selectedProducts = session()->get('selected_products', []);
        return view('Ofertas::crear_oferta', [
            'title' => 'Crear Oferta',
            'description' => 'Crear una nueva oferta',
            'products' => $products,
            'selectedProducts' => $selectedProducts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio_total' => 'required|numeric',
            'monto_total_productos' => 'required|numeric',
            'porcentaje_descuento' => 'required|numeric|min:0|max:100',
            'descripcion' => 'nullable|string',
            'productos' => 'required|array', // IDs de productos seleccionados
        ]);

        // Crear la oferta
        $oferta = Oferta::create([
            'nombre' => $request->nombre,
            'precio_total' => $request->precio_total,
            'monto_total_productos' => $request->monto_total_productos,
            'porcentaje_descuento' => $request->porcentaje_descuento,
            'descripcion' => $request->descripcion,
        ]);

        // Asociar los productos seleccionados a la oferta en la tabla oferta_productos
        $productIDs = $request->input('productos', []);
        // $productIds = array_unique($request->input('productos', []));
        // $oferta->products()->attach($productIDs); // Inserta los registros en oferta_productos
        $oferta->products()->sync($productIDs); // Inserta los registros en oferta_productos

        // Limpiar la sesión después de guardar
        session()->forget('selected_products');

        return redirect()->route('ofertas.crear')->with('success', 'Oferta creada con éxito y productos asociados');
    }
}
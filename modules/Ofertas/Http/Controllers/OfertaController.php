<?php

namespace Modules\Ofertas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Ofertas\Models\Oferta; // Asegúrate de usar el namespace del módulo
// use App\Models\Oferta; // Asegúrate de usar el namespace del módulo

class OfertaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = app('Modules\Ofertas\Http\Controllers\MiModuloController')->obtenerProductos();
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
            'productos' => 'required|array',
        ]);

        $oferta = Oferta::create([
            'nombre' => $request->nombre,
            'precio_total' => $request->precio_total,
            'monto_total_productos' => $request->monto_total_productos,
            'porcentaje_descuento' => $request->porcentaje_descuento,
            'descripcion' => $request->descripcion,
        ]);

        $oferta->productos()->attach($request->productos);

        return redirect()->route('ofertas.crear')->with('success', 'Oferta creada con éxito');
    }
}
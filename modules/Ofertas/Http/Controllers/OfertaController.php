<?php

namespace Modules\Ofertas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Ofertas\Models\Oferta; // Asegúrate de usar el namespace del módulo
use App\Models\Product; // Asegúrate de usar el namespace del modelo Product

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Dashboard\ProductsController;
use Modules\Ofertas\Http\Controllers\TipoOfertaController;


class OfertaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $products = app('Modules\Ofertas\Http\Controllers\MiModuloController')->obtenerProductos();
        //$products = Product::all(); // Obtener todos los productos de la base de datos
        $products = Product::with('unit_quantities')->get();
        $tipo_ofertas = TipoOfertaController::obtenerTodosTipoOferta();
        $selectedProducts = session()->get('selected_products', []);
        return view('Ofertas::crear_oferta', [
            'title' => 'Crear Oferta',
            'description' => 'Crear una nueva oferta',
            'products' => $products,
            'tipo_ofertas' => $tipo_ofertas,
            'selectedProducts' => $selectedProducts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */public function store(Request $request)
{
    try {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio_total' => 'required|numeric',
            'monto_total_productos_sin_descuento' => 'required|numeric',
            'porcentaje_descuento' => 'required|numeric|min:0|max:100',
            'tipo_oferta_id' => 'required|exists:tipo_ofertas,id',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string',
            'productos' => 'required|array',
            'productos.*' => 'exists:nexopos_products,id',
        ]);

        $oferta = Oferta::create([
            'nombre' => $request->nombre,
            'precio_total' => $request->precio_total,
            'monto_total_productos' => $request->monto_total_productos_sin_descuento,
            'porcentaje_descuento' => $request->porcentaje_descuento,
            'tipo_oferta_id' => $request->tipo_oferta_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_final' => $request->fecha_final,
            'descripcion' => $request->descripcion,
        ]);

        $oferta->products()->sync($request->productos);

        session()->forget('selected_products');

        return redirect()->route('ofertas.crear')->with('success', 'Oferta creada con éxito y productos asociados.');

    } catch (\Exception $e) {
        Log::error('Error al crear oferta: ' . $e->getMessage());
        return back()->with('error', 'Error al crear la oferta: ' . $e->getMessage())->withInput();
    }
}



    // PARA OBTENER OFERTAS ACTIVAS
    public function getActiveOffers()
    {
        try {
            // Añadir logging para debugging
            Log::info('Iniciando getActiveOffers');

            $ofertas = Oferta::with(['products', 'tipoOferta'])
                ->where('estado', true)
                ->where('fecha_inicio', '<=', now())
                ->where('fecha_final', '>=', now())
                ->get();

            Log::info('Ofertas encontradas: ' . $ofertas->count());
            Log::info('Productos en la primera oferta: ' . $ofertas->first()->products->count());

            $data = $ofertas->map(function ($oferta) {
                $dias_restantes = now()->diffInDays($oferta->fecha_final); // Calcular los días restantes
                $dias_restantes = $dias_restantes < 0 ? 0 : $dias_restantes; // Asegurarse de que no sea negativo

                // Redondear a un entero los dias restantes     
                $dias_restantes = ceil($dias_restantes);
                return [
                    'id' => $oferta->id,
                    'nombre' => $oferta->nombre,
                    'descripcion' => $oferta->descripcion,
                    'porcentaje_descuento' => floatval($oferta->porcentaje_descuento),
                    'fecha_inicio' => $oferta->fecha_inicio->format('Y-m-d'),
                    'fecha_final' => $oferta->fecha_final->format('Y-m-d'),
                    'dias_restantes' => $dias_restantes,
                    'tipo_oferta' => $oferta->tipoOferta ? [
                        'id' => $oferta->tipoOferta->id,
                        'nombre' => $oferta->tipoOferta->nombre
                    ] : null,
                    'productos' => $oferta->products->map(function ($product) {
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'price' => floatval($product->tax_value),
                            'barcode' => $product->barcode
                        ];
                    })->toArray()
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getActiveOffers: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'status' => 'error',
                'message' => 'Error al cargar las ofertas: ' . $e->getMessage()
            ], 500);
        }
    }
}

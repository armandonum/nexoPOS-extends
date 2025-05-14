<?php

namespace Modules\Ofertas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Ofertas\Models\Oferta; // Asegúrate de usar el namespace del módulo
use App\Models\Product;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Dashboard\ProductsController;
use Modules\Ofertas\Http\Controllers\TipoOfertaController;
use Modules\Ofertas\Models\tipo_oferta; 


class OfertaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
     */
    public function store(Request $request)
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




    public function getActiveOffers()
    {
        try {
     
            Log::info('Iniciando getActiveOffers');

            $ofertas = Oferta::with(['products', 'tipoOferta'])
                ->where('estado', true)
                
                ->get();

            Log::info('Ofertas encontradas: ' . $ofertas->count());
            Log::info('Productos en la primera oferta: ' . $ofertas->first()->products->count());

            $data = $ofertas->map(function ($oferta) {
                $dias_restantes = now()->diffInDays($oferta->fecha_final); 
                $dias_restantes = $dias_restantes < 0 ? 0 : $dias_restantes; 

 
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


    public function updateEstate(Request $request, $id)
    {
        try {
            $request->validate([
                'estado' => 'required|boolean'
            ]);

            $oferta = Oferta::findOrFail($id);
            $oferta->update([
                'estado' => $request->estado
            ]);

            return redirect()->route('ofertas.index')->with('success', 'Estado de la oferta actualizado con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar oferta: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar el estado de la oferta: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
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

        $oferta = Oferta::findOrFail($id);

        $oferta->update([
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

        return redirect()->route('ofertas.index')->with('success', 'Oferta actualizada correctamente.');
    } catch (\Exception $e) {
        Log::error('Error al actualizar la oferta: ' . $e->getMessage());
        return back()->with('error', 'Error al actualizar la oferta: ' . $e->getMessage())->withInput();
    }
}

    public function edit($id)
{
    $products = Product::with('unit_quantities')->get();
    $oferta = Oferta::findOrFail($id); 
    $selectedProducts = session()->get('selected_products', []);
    $tipo_ofertas = TipoOfertaController::obtenerTodosTipoOferta();

    return view('Ofertas::editar', compact('oferta', 'tipo_ofertas', 'products', 'selectedProducts'))
        ->with([
            'title' => 'Editar Oferta',
            'description' => 'Editar una oferta existente'
        ]);
}
    public function destroy($id)
    {
        try {
            $oferta = Oferta::findOrFail($id);
            $oferta->products()->detach(); 
            $oferta->delete();

            return redirect()->route('ofertas.index')->with('success', 'Oferta eliminada con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar oferta: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la oferta: ' . $e->getMessage());
        }
    }
    public function index()
    {
        $ofertas = Oferta::with(['products', 'tipoOferta'])->get();
        return view('Ofertas::listar_ofertas', [
            'title' => 'Listado de Ofertas',
            'description' => 'Gestiona las ofertas existentes',
            'ofertas' => $ofertas
        ]);
    }

   
}

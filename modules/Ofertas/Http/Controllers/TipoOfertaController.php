<?php

namespace Modules\Ofertas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Ofertas\Models\TipoOferta;

class TipoOfertaController extends Controller
{
    public static function obtenerTodosTipoOferta()
    {
        return TipoOferta::all();
    }

    public static function cargarFormularioTipoOferta()
    {
        return view('Ofertas::crear_tipo_oferta', [
            'title' => 'Crear Tipo de Oferta',
            'description' => 'Crear un nuevo tipo de oferta',
        ]);
    }

    public function almacenarTipoOferta(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $tipoOferta = TipoOferta::create([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'mensaje' => 'Tipo de oferta creado exitosamente.',
                'tipo' => [
                    'id' => $tipoOferta->id,
                    'nombre' => $tipoOferta->name,
                    'descripcion' => $tipoOferta->descripcion
                ]
            ]);
        }

        return redirect()->route('ofertas.crear')->with('success', 'Tipo de oferta creado exitosamente.');
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Ofertas\Models\OfertaProducto;
use Modules\Ofertas\Models\Oferta;
use App\Models\Product;

class OfertaProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener 20 reservas aleatorias sin repetir
        $ofertas = Oferta::inRandomOrder()->take(10)->get();
        $productos = Product::inRandomOrder()->take(10)->get();

        foreach ($ofertas as $oferta) {
            foreach ($productos as $producto) {
                OfertaProducto::factory()->create([
                    'oferta_id' => $oferta->id,
                    'producto_id' => $producto->id,
                ]);
            }
        }
    }
}

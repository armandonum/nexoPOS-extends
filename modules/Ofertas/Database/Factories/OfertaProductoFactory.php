<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
// use App\Models\OfertaProducto;
use Modules\Ofertas\Models\Oferta;
use Modules\Ofertas\Models\OfertaProducto;
use App\Models\Product;



class OfertaProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = OfertaProducto::class;
    public function definition(): array
    {
    
        $product = Product::all()->random();
        $oferta = Oferta::all()->random();

        return [
            'oferta_id' => $oferta->id,
            'producto_id' => $product->id
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Ofertas\Models\Oferta;
// use App\Models\Oferta;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Oferta>
 */
class OfertaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Oferta::class;
    public function definition(): array
    {
        // id (PK)
        // nombre (nombre de la oferta)
        // precio_total (precio total después de descuento)
        // monto_total_productos (suma de precios de productos sin descuento)
        // porcentaje_descuento (porcentaje aplicado)
        // descripcion (descripción de la oferta)
        return [
            'nombre' => $this->faker->word(),
            'precio_total' => $this->faker->randomFloat(2, 1, 100),
            'monto_total_productos' => $this->faker->randomFloat(2, 1, 100),
            'porcentaje_descuento' => $this->faker->randomFloat(2, 0, 100),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}

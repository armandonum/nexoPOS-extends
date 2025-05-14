<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Ofertas\Models\Oferta;
use Modules\Ofertas\Models\tipo_oferta;

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
        $tipo_oferta = tipo_oferta::all()->random();
        return [
            'nombre' => $this->faker->word(),
            'precio_total' => $this->faker->randomFloat(2, 1, 100),
            'monto_total_productos' => $this->faker->randomFloat(2, 1, 100),
            'porcentaje_descuento' => $this->faker->randomFloat(2, 0, 100),
            'descripcion' => $this->faker->sentence(),
            'estado' => $this->faker->boolean(),
            'tipo_oferta_id' => $this->faker->$tipo_oferta->id, 
            'fecha_inicio' => $this->faker->date(),
            'fecha_final' => $this->faker->date(),
        ];
    }
}

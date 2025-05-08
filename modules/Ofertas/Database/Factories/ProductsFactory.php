<?php

namespace Modules\Ofertas\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Ofertas\Models\Products;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Ofertas\Models\Products>
 */
class ProductsFactory extends Factory
{
    protected $model = Products::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'size' => $this->faker->word(),
            // 'category_id' => \App\Models\ProductCategory::factory(),
        ];
    }
}
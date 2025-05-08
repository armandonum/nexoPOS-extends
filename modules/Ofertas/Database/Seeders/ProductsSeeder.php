<?php

namespace Modules\Ofertas\Database\Seeders; 

use Illuminate\Database\Seeder;
use Modules\Ofertas\Models\Products;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        Products::factory()->count(20)->create();
    }
}
<?php

namespace Database\Seeders;

use App\Models\Oferta as ModelsOferta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Ofertas\Models\Oferta;
// use App\Models\Oferta;

class OfertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Oferta::factory()->count(10)->create();
    }
}

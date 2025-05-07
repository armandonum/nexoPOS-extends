<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Modules\Ofertas\Database\Seeders\ProductsSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call( RewardSystemSeeder::class );
        // $this->call( CustomerGroupSeeder::class );
        // $this->call( UnitGroupSeeder::class );
        // $this->call( TaxSeeder::class );
        // $this->call( ProductsSeeder::class );

        $this->call([
            ProductsSeeder::class,
        ]);
    }
}

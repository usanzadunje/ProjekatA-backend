<?php

namespace Database\Seeders;

use App\Models\Cafe;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CafeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Cafe::factory(120)
            ->hasTables(4)
            ->hasProducts(5)
            ->create();
    }
}

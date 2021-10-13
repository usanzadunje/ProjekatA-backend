<?php

namespace Database\Seeders;

use App\Models\Cafe;
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

        Cafe::factory(500)
            ->hasTables(4)
            ->hasProducts(300)
            ->hasCategories(5)
            ->create();
    }
}

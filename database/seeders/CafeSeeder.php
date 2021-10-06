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

        Cafe::factory(120)
            ->hasTables(4)
            ->hasProducts(5)
            ->hasCategories(5)
            ->create();
    }
}

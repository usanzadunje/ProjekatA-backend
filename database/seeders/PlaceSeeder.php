<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Place::factory(50)
            ->hasTables(10)
            ->hasProducts(10)
            ->hasCategories(5)
            ->create();
    }
}

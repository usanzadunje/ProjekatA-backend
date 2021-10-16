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

        Place::factory(500)
            ->hasTables(10)
            ->hasProducts(200)
            ->hasCategories(10)
            ->create();
    }
}

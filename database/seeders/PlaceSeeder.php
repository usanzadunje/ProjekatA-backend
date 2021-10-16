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

        Place::factory(1000)
            ->hasTables(4)
            ->hasProducts(200)
            ->hasCategories(5)
            ->create();
    }
}

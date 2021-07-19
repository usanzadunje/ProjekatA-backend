<?php

namespace Database\Seeders;

use App\Models\Cafe;
use App\Models\Offering;
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
        $offerings = Offering::factory(10)->create();

        Cafe::factory(120)
            ->hasTables(4)
            ->hasAttached($offerings->skip(2)->take(4), [
                'created_at' => now(),
                'updated_at' => now(),
            ])
            ->create();
    }
}

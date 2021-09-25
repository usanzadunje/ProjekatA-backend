<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++)
        {
            for($j = 0; $j < 4; $j++)
            {
                if($j === 0)
                {
                    Image::create([
                        'path' => "/places/Cafe $i/1_1cafe.png",
                        'is_main' => true,
                        'cafe_id' => $i,
                    ]);
                }
                else
                {
                    Image::create([
                        'path' => "/places/Cafe $i/2_{$j}cafe.png",
                        'cafe_id' => $i,
                    ]);
                }
            }
        }

    }
}

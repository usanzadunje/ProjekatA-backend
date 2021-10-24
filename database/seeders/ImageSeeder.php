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
                        'path' => "/places/$i/1_1cafe.png",
                        'is_main' => true,
                        'is_logo' => true,
                        'imagable_id' => $i,
                        'imagable_type' => 'App\Models\Place',
                    ]);
                }
                else
                {
                    Image::create([
                        'path' => "/places/$i/2_{$j}cafe.png",
                        'imagable_id' => $i,
                        'imagable_type' => 'App\Models\Place',
                    ]);
                }
            }
        }
        for($i = 1; $i <= 10; $i++)
        {
            for($j = 1; $j <= 5; $j++)
            {
                if($j === 1)
                {
                    Image::create([
                        'path' => "/places/$i/products/product_$j.jpg",
                        'is_main' => true,
                        'imagable_id' => $i,
                        'imagable_type' => 'App\Models\Product',
                    ]);
                }
                else
                {
                    Image::create([
                        'path' => "/places/$i/products/product_$j.jpg",
                        'imagable_id' => $i,
                        'imagable_type' => 'App\Models\Product',
                    ]);
                }
            }
        }
    }
}

<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => str_replace('.', '', $this->faker->text(15)),
            'description' => $this->faker->text(50),
            'price' => $this->faker->numberBetween(100, 3000),
            'category_id' => rand(1, 3),
        ];
    }
}

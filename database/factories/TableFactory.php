<?php

namespace Database\Factories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Table::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'empty' => rand(0, 1),
            'smoking_allowed' => rand(0, 1),
            'seats' => rand(2, 10),
            'top' => rand(0, 140),
            'left' => rand(0, 100),
        ];
    }
}

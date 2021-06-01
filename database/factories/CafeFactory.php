<?php

namespace Database\Factories;

use App\Models\Cafe;
use Illuminate\Database\Eloquent\Factories\Factory;

class CafeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cafe::class;

    public $store = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if(++$this->store < 20)
        {
            return [
                'name' => 'Cafe ' . $this->store,
                'city' => 'City ' . $this->store,
                'address' => 'Address ' . $this->store,
                'latitude' => $this->store,
                'longitude' => $this->store,
                'phone' => $this->store . $this->store . $this->store . $this->store . $this->store . $this->store,
                'email' => 'cafe' . $this->store . '@live.com',
            ];
        }

        return [
            'name' => $this->faker->name,
            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'phone' => $this->faker->numberBetween(100000, 900000),
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}

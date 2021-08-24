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
            if($this->store === 1)
            {
                return [
                    'name' => 'Cafe ' . 1,
                    'city' => 'City ' . 1,
                    'address' => 'Address ' . 1,
                    'latitude' => '43.31782022634103',
                    'longitude' => '21.89577969079342',
                    'phone' => '111111',
                    'email' => 'cafe1@live.com',
                    'user_id' => 2,
                ];
            }

            if($this->store === 2)
            {
                return [
                    'name' => 'Cafe ' . 2,
                    'city' => 'City ' . 2,
                    'address' => 'Address ' . 2,
                    'latitude' => '43.31782022634103',
                    'longitude' => '21.89577969079340',
                    'phone' => '222222',
                    'email' => 'cafe2@live.com',
                    'user_id' => 3,
                ];
            }

            return [
                'name' => 'Cafe ' . $this->store,
                'city' => 'City ' . $this->store,
                'address' => 'Address ' . $this->store,
                'latitude' => $this->faker->latitude,
                'longitude' => $this->faker->longitude,
                'phone' => $this->store . $this->store . $this->store . $this->store . $this->store . $this->store,
                'email' => 'cafe' . $this->store . '@live.com',
                'user_id' => 1,
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
            'user_id' => 1,

        ];
    }
}

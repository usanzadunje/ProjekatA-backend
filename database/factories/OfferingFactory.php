<?php

namespace Database\Factories;

use App\Models\Offering;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offering::class;

    public $store = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if(++$this->store < 3){
            return [
                'name' => 'Pice ' . $this->store,
                'tag' => 'hrana',
            ];
        }

        return [
            'name' => 'Pice ' . $this->store,
            'tag' => 'pice',
        ];
    }
}

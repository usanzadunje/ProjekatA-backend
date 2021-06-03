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
    public $storeOne = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if(++$this->store < 5){
            return [
                'name' => 'Hrana ' . $this->store,
                'tag' => 'hrana',
            ];
        }
        return [
            'name' => 'Pice ' . ++$this->storeOne,
            'tag' => 'pice',
        ];
    }
}

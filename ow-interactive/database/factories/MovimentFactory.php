<?php

namespace Database\Factories;

use App\Models\Moviment;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovimentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Moviment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' =>  $this->faker->randomFloat(2, 10, 300),
            'moviment_type_id' => rand(1, 3)
        ];
    }
}

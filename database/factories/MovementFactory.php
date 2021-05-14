<?php

namespace Database\Factories;

use App\Models\Movement;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->rand(1, 100),
            'movement_type_id' => $this->faker->rand(1, 2),
            //'value' => $this->faker->mo
        ];
    }
}

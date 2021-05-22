<?php

namespace Database\Factories;

use App\Models\Financial;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinancialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Financial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'current_balance' => $this->faker->randomFloat(2, 10, 300),
        ];
    }
}

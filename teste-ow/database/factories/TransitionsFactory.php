<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransitionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $types = ['debit', 'credit', 'chargeback'];
        $users = User::all()->pluck('id')->toArray();
        
        return [
            'types'   => $types[rand(1,3)],
            'values'  => $this->faker->randomDigit,
            'user_id' => $this->faker->randomElement($users)
        ];
    }
}

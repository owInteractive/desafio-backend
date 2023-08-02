<?php

namespace Database\Factories;

use App\Models\Movimentacao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movimentacao>
 */
class MovimentacoesSeederFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Movimentacao::class;
    public function definition(): array
    {
        return [
            'operacao' => 'CREDITO',
            'valor' => rand(1, 9999),
        ];
    }
}

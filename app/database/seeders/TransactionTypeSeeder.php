<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\TransactionType::create(
            [
                'name' => 'Crédito'
            ]
        );

        \App\Models\TransactionType::create(
            [
                'name' => 'Débito'
            ]
        );

        \App\Models\TransactionType::create(
            [
                'name' => 'Estorno'
            ]
        );
    }
}
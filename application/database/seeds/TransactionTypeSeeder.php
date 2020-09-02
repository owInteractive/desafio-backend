<?php

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
        \App\Models\TransactionType::create(['title' => 'Crédito']);
        \App\Models\TransactionType::create(['title' => 'Débito']);
        \App\Models\TransactionType::create(['title' => 'Estorno']);
    }
}

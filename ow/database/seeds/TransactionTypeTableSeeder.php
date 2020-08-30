<?php

use Illuminate\Database\Seeder;

class TransactionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TransactionType::class)->create([
        	'name' => 'Débito'
        ]);

        factory(App\TransactionType::class)->create([
        	'name' => 'Crédito'
        ]);

        factory(App\TransactionType::class)->create([
        	'name' => 'Estorno'
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class OperationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Operation::class)->create([
        	'id_user' => 1, 'id_transaction_type' => 3, 'id_status_type' => 2, 'value' => 120.00
        ]);
        factory(App\Operation::class)->create([
        	'id_user' => 2, 'id_transaction_type' => 2, 'id_status_type' => 2, 'value' => 59.90
        ]);
        factory(App\Operation::class)->create([
        	'id_user' => 3, 'id_transaction_type' => 1, 'id_status_type' => 1, 'value' => 580.00
        ]);
        factory(App\Operation::class)->create([
        	'id_user' => 3, 'id_transaction_type' => 1, 'id_status_type' => 2, 'value' => 100.00
        ]);
        factory(App\Operation::class)->create([
        	'id_user' => 2, 'id_transaction_type' => 1, 'id_status_type' => 2, 'value' => 800.00
        ]);
        factory(App\Operation::class)->create([
        	'id_user' => 1, 'id_transaction_type' => 3, 'id_status_type' => 2, 'value' => 99.90
        ]);
        factory(App\Operation::class)->create([
        	'id_user' => 2, 'id_transaction_type' => 1, 'id_status_type' => 3, 'value' => 74.00
        ]);
        factory(App\Operation::class)->create([
        	'id_user' => 3, 'id_transaction_type' => 1, 'id_status_type' => 1, 'value' => 33.90
        ]);
        factory(App\Operation::class)->create([
        	'id_user' => 1, 'id_transaction_type' => 1, 'id_status_type' => 1, 'value' => 50.00
        ]);
    }
}

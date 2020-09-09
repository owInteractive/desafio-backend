<?php

use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Transaction::create(
            [
                'user_id' => 1,
                'transaction_type_id' => 1,
                'value' => 100
            ]
        );

        \App\Models\Transaction::create(
            [
                'user_id' => 1,
                'transaction_type_id' => 2,
                'value' => 200
            ]
        );

        \App\Models\Transaction::create(
            [
                'user_id' => 1,
                'transaction_type_id' => 3,
                'value' => 300
            ]
        );

        \App\Models\Transaction::create(
            [
                'user_id' => 1,
                'transaction_type_id' => 1,
                'value' => 400
            ]
        );

        \App\Models\Transaction::create(
            [
                'user_id' => 1,
                'transaction_type_id' => 2,
                'value' => 500
            ]
        );

        \App\Models\Transaction::create(
            [
                'user_id' => 1,
                'transaction_type_id' => 3,
                'value' => 600
            ]
        );

        \App\Models\Transaction::create(
            [
                'user_id' => 1,
                'transaction_type_id' => 1,
                'value' => 700
            ]
        );
    }
}

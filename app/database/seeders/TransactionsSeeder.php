<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();

        foreach ($users as $user) {
            for ($i = 0; $i < 10; $i++) {
                \App\Models\Transaction::create(
                    [
                        'user_id' => $user->id,
                        'transaction_type_id' => rand(1,3),
                        'value' => rand(100, 1000)
                    ]
                );
            }
        }
    }
}
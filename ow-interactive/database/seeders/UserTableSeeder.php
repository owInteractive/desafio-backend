<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::factory(2)->create();

        $users->each(function ($user) {
            $financial = \App\Models\Financial::factory()->make();
            $financial->user_id = $user->id;
            $financial->save();

            $moviments = \App\Models\Moviment::factory()->count(10)->make();
            $moviments->each(function ($moviment) use ($financial) {
                $moviment->created_at = now();
                $moviment->updated_at = now();
                $moviment->financial_id = $financial->id;
                $moviment->save();
            });
            $allMovimentsValue = $moviments->sum('value');
            $debitMovimentValue = $moviments->where('moviment_type_id', 1)->sum('value');
            $financial->current_balance = $allMovimentsValue - $debitMovimentValue;
            $financial->save();
        });
    }
}

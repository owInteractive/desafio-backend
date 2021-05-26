<?php

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Jose Antonio',
                'email' => 'email@email.com.br',
                'birthday' => Carbon::create(rand(1960, 2000), rand(1, 12), rand(1, 28)),
                'opening_balance' => 0,
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Jose Marcio',
                'email' => 'email2@email.com.br',
                'birthday' => Carbon::create(rand(1960, 2000), rand(1, 12), rand(1, 28)),
                'opening_balance' => 0,
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Jose Pereira',
                'email' => 'email3@email.com.br',
                'birthday' => Carbon::create(rand(1960, 2000), rand(1, 12), rand(1, 28)),
                'opening_balance' => 0,
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Jose Maria',
                'email' => 'email4@email.com.br',
                'birthday' => Carbon::create(rand(1960, 2000), rand(1, 12), rand(1, 28)),
                'opening_balance' => 0,
                'created_at' => date("Y-m-d H:i:s")
            ]
        ]);
    }
}

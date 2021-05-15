<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Isaac Newton', 'email' => 'isaac@gmail', 'birthday'=>'2000-01-01','opening_balance'=>'0'],
            ['name' => 'Aristóteles', 'email' => 'ari@gmail', 'birthday'=>'2000-01-01','opening_balance'=>'0']
        ];

        DB::table('users')->insert($data); 
    }
}

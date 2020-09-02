<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create(
            [
                'name'           => 'Yves Clêuder',
                'email'          => 'yves.cl@live.com',
                'password'       => bcrypt('123456'),
                'birthday'       => '1996-10-24',
                'amount_initial' => 5
            ]
        );
    }
}

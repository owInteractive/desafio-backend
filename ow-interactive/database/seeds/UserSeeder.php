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
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('admin'),
                'birthday'       => '1994-05-18'
            ]
        );

        \App\Models\User::create(
            [
                'name'           => 'User',
                'email'          => 'user@user.com',
                'password'       => bcrypt('user'),
                'birthday'       => '1994-05-18'
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create(
            [
                'name' => 'Administrador',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'birthday' => '2000-01-01',
                'opening_balance' => 1000.00

            ]
        );
        
        \App\Models\User::factory(10)->create();
    }
}

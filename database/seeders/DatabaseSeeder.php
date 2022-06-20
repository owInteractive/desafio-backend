<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'admin',
             'email' => 'admin@admin.com',
             'birthday' => '1986-01-04',
             'opening_balance' => 0,
             'email_verified_at' => now(),
             'password' => 'password',
             'remember_token' => Str::random(10),
         ]);

        \App\Models\Movement::factory(300)->create();
    }
}

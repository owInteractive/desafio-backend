<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
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
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$QCZoUHowEJHFxGf3bYWmMOdiF2a1Mffg.zUVLhzlV4/WGEH6S8pby', //admin
            'api_token' => 'liAA3K2EBXgtGKbxYFquWWmvK1buSKk0PelN77nTCaezQrrOiZSZYl6jkE0w',
            'birthday' => date('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

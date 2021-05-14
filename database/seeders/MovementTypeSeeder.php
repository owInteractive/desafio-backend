<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('movement_types')->insert([
            [
                'title' => 'Débito',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Crédito',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Estorno',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}

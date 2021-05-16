<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class MovementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['operation' => 'credit', 'value' => '100.00', 'user_id'=>1],
            ['operation' => 'debit', 'value' => '30.00', 'user_id'=>1],
            ['operation' => 'reversal', 'value' => '60.00', 'user_id'=>1],
            ['operation' => 'credit', 'value' => '500.00', 'user_id'=>2],
            ['operation' => 'debit', 'value' => '100.00', 'user_id'=>2],
            ['operation' => 'reversal', 'value' => '10.00', 'user_id'=>2],
        ];

        DB::table('movements')->insert($data);
    }
}

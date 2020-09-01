<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('operation_types')->insert([
            array(
                'id' => 1,
                'name' => 'Crédito',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 2,
                'name' => 'Débito',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 3,
                'name' => 'Estorno',
                'created_at' => date("Y-m-d H:i:s")
            ),
        ]);
    }
}

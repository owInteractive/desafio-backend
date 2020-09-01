<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('operations')->insert([
            ['user_id' => 1, 'operation_type_id' => 1, 'amount' => 100.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 1, 'operation_type_id' => 1, 'amount' => 200.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 1, 'operation_type_id' => 2, 'amount' => 150.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 1, 'operation_type_id' => 1, 'amount' => 500.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 1, 'operation_type_id' => 2, 'amount' => 755.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 2, 'operation_type_id' => 2, 'amount' => 50.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 2, 'operation_type_id' => 2, 'amount' => 525.25, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 3, 'operation_type_id' => 1, 'amount' => 300.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 3, 'operation_type_id' => 3, 'amount' => 50.25, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 3, 'operation_type_id' => 2, 'amount' => 130.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 2, 'operation_type_id' => 3, 'amount' => 25.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 3, 'operation_type_id' => 1, 'amount' => 800.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 3, 'operation_type_id' => 1, 'amount' => 200.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 4, 'operation_type_id' => 1, 'amount' => 150.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 4, 'operation_type_id' => 1, 'amount' => 150.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 4, 'operation_type_id' => 2, 'amount' => 500.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 4, 'operation_type_id' => 2, 'amount' => 230.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 4, 'operation_type_id' => 2, 'amount' => 410.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 4, 'operation_type_id' => 2, 'amount' => 130.00, 'created_at' => date("Y-m-d H:i:s")],
            ['user_id' => 4, 'operation_type_id' => 1, 'amount' => 120.00, 'created_at' => date("Y-m-d H:i:s")],
        ]);
    }
}

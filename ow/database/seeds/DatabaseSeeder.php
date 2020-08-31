<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(StatusTypeTableSeeder::class);
        $this->call(TransactionTypeTableSeeder::class);
        $this->call(OperationsTableSeeder::class);
    }
}

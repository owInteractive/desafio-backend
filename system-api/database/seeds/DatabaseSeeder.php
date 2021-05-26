<?php

use App\Models\OperationType;
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
        $this->call(UserSeeder::class);
        $this->call(OperationTypeSeeder::class);
        $this->call(OperationSeeder::class);
    }
}

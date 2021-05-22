<?php

namespace Database\Seeders;

use App\Models\MovimentType;
use Illuminate\Database\Seeder;

class MovimentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MovimentType::create(["name" => 'Débito']);
        MovimentType::create(["name" => 'Crédito']);
        MovimentType::create(["name" => 'Extorno']);
    }
}

<?php

use Illuminate\Database\Seeder;

class StatusTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\StatusType::class)->create([
        	'name' => 'Aprovada'
        ]);

        factory(App\StatusType::class)->create([
        	'name' => 'Rejeitada'
        ]);

        factory(App\StatusType::class)->create([
        	'name' => 'Aguardando'
        ]);
    }
}

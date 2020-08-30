<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'name' => 'Administrador', 'email' => 'admin@admin.com', 'birthday' => '1970-12-05', 'password' =>  Hash::make('admin')
        ]);
        factory(App\User::class)->create([
        	'name' => 'Maria da Silva', 'email' => 'maria@silva.com', 'birthday' => '1970-12-05', 'password' => Hash::make('123456')
        ]);
        factory(App\User::class)->create([
        	'name' => 'Joāo Santos', 'email' => 'joao@santos.com', 'birthday' => '1985-05-08', 'password' => Hash::make('123456')
        ]);
        factory(App\User::class)->create([
        	'name' => 'Carlos Daniel', 'email' => 'carlos@daniel.com', 'birthday' => '1990-08-12', 'password' => Hash::make('123456')
        ]);
    }
}

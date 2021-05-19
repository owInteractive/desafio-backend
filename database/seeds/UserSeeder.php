<?php

use App\User;
use Illuminate\Database\Seeder;

/*
 * This class also seed the transaction table
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
             'email' => 'email@mail',
            'birthday' => "2000-03-02",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'name'=> 'matheus'
        ]);
        factory(User::class,20)->create()->each(function ($user) {
            factory(\App\Models\Transaction::class,2)->create([
                'user_id' => $user->id
            ]);
        });

    }
}

<?php

namespace Database\Seeders;

use App\Models\Movimentacao;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            $users = User::factory()->count(20)->make()->toArray();
            foreach ($users as $key => $user) {
                $user=User::create($user);
                $user->movimentacoes()->saveMany([
                    new Movimentacao([
                        'operacao' => 'DEBITO',
                        'valor' => rand(1, 9999)
                    ]),
                    new Movimentacao([
                        'operacao' => 'CREDITO',
                        'valor' => rand(1, 9999)
                    ]),
                    new Movimentacao([
                        'operacao' => 'ESTORNO',
                        'valor' => rand(1, 9999)
                    ]),
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    /**
     * Criação de um usuário
     *
     */
    public function testUserCreate()
    {
        $payload = [
            'name'           => $this->faker->name(),
            'email'          => $this->faker->email(),
            'password'       => '123456',
            'birthday'       => '1996-10-24',
            'amount_initial' => "500.00"
        ];

        $this->postJson('/api/users', $payload)
            ->assertStatus(200);
    }

    /**
     * Verifica se é maior de idade
     *
     */
    public function testOlderThan18Years()
    {
        $payload = [
            'name'           => $this->faker->name(),
            'email'          => $this->faker->email(),
            'password'       => '123456',
            'birthday'       => '2015-10-24',
            'amount_initial' => "500.00"
        ];

        $this->postJson('/api/users', $payload)
            ->assertStatus(422);
    }

    /**
     * Verifica se a data de aniversário está no padrão correto
     */
    public function testBirthDayIsCorrect()
    {
        $payload = [
            'name'           => $this->faker->name(),
            'email'          => $this->faker->email(),
            'password'       => '123456',
            'birthday'       => '2015-24-10',
            'amount_initial' => "500.00"
        ];

        $this->postJson('/api/users', $payload)
            ->assertStatus(422);
    }

    /**
     * Verifica se a rota de listar usuários está funcionando
     */
    public function testListUsers()
    {
        $client = \Laravel\Passport\Client::where('password_client', 1)->whereNull('user_id')->first();

        $payload = [
            'username'      => 'yves.cl@live.com',
            'password'      => '123456',
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret
        ];

        $authenticate = $this->postJson('/oauth/token', $payload);
        $content      = json_decode($authenticate->getContent());

        $this->get('/api/users', ['Authorization' => 'Bearer ' . $content->access_token])
            ->assertStatus(200);
    }
}

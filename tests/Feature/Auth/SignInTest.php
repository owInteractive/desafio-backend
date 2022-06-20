<?php

namespace Feature\Auth;

use Tests\TestCase;

class SiginInTest extends TestCase
{
    public function test_siginin_user()
    {
        $payload = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'password_confirmation' => 'admin',
            'birthday' => '1986-01-04',
            'opening_balance' => 0.0,
        ];
        $response = $this->postJson('/api/auth/signin', $payload);

        $expectedResponse = [
            "message",
            "data" => [
                "name",
                "email",
                "birthday",
                "opening_balance",
                "updated_at",
                "created_at",
                "id"
            ]
        ];

        $response
            ->assertStatus(200)
            ->assertJsonStructure($expectedResponse);
    }
}

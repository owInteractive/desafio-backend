<?php

namespace Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{

    public function test_login_user()
    {
        $user = User::factory()->create();
        $payload = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->post('/api/auth/login', $payload);

        $expectedResponse = [
            "message",
	        "data" => [
                "user" => [
                    "id",
                    "name",
                    "email",
                    "birthday",
                    "opening_balance",
                    "email_verified_at",
                    "created_at",
                    "updated_at",
                ],
                "token",
            ]
        ];

        $response
            ->assertStatus(201)
            ->assertJsonStructure($expectedResponse);
    }
}

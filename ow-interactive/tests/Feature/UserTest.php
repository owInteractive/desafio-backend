<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    /**
     * testSuccessfulRegistration
     * testing register user
     */
    public function testSuccessfulRegistration()
    {
        $userData = [
            "name"           => $this->faker->name(),
            "email"          => $this->faker->email(),
            "password"       => "ow-interactive",
            "birthday"       => "1994-05-18"
        ];

        $this->postJson('/api/users/register', $userData)
            ->assertStatus(200);
    }
}

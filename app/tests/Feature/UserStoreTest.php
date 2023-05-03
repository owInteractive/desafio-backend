<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserStoreTest extends TestCase
{
    public function testStoreUserSuccessful()
    {
        $user = [
            "name"           => "Antonio da Silva",
            "email"          => "antonio@email.com",
            "password"       => "password",
            "birthday"       => "2000-01-01"
        ];

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->postJson('/api/user/store', $user);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email' => $user['email'],
            'birthday' => $user['birthday'],
        ]);
    }
}

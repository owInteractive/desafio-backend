<?php

namespace Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Set up the test environment
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_list_users()
    {
        User::factory(40)->create();

        $response = $this->actingAs($this->user)->get('/api/users');

        $expectedResponse = [
            "message",
            "data" => [
                '*' => [
                    "id",
                    "name",
                    "email",
                    "birthday",
                    "opening_balance",
                    "email_verified_at",
                    "created_at",
                    "updated_at",
                ]
            ]
        ];

        $response
            ->assertStatus(200)
            ->assertJsonStructure($expectedResponse);
    }

    public function test_list_one_user()
    {
        User::factory(40)->create();

        $response = $this->actingAs($this->user)->get('/api/users/'.$this->user->id);

        $expectedResponse = [
            "message",
            "data" => [
                    "id",
                    "name",
                    "email",
                    "birthday",
                    "opening_balance",
                    "email_verified_at",
                    "created_at",
                    "updated_at",
            ]
        ];

        $response
            ->assertStatus(200)
            ->assertJsonStructure($expectedResponse);
    }

    public function test_delete_one_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->user)->delete('/api/users/'.$user->id);

        $expectedResponse = [
            "message",
            "data",
        ];

        $response
            ->assertStatus(200)
            ->assertJsonStructure($expectedResponse);
    }
}

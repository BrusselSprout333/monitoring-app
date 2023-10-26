<?php

namespace Tests\Unit;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ApiTest extends TestCase
{
    public function test_get_user_by_id(): void
    {
        $response = $this->getJson('/api/users/2');

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'email', 'first_name', 'last_name', 'avatar']);
    }

    public function test_cant_get_nonexistent_user_by_id(): void
    {
        $response = $this->getJson('/api/users/23');

        $response->assertStatus(404);
    }

    public function test_create_user()
    {
        $request = [
            'name' => 'Mark',
            'job'  => 'Manager'
        ];

        $response = $this->postJson('/api/users', $request);

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['id']);
    }

    public function test_cant_create_user_with_invalid_data()
    {
        $request = [
            'name' => "",
            'job'  => ""
        ];

        $response = $this->postJson('/api/users', $request);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'name' => [
                        'The name field is required.'
                    ],
                    'job'  => [
                        'The job field is required.'
                    ]
                ]
            ]);
    }

    public function test_get_all_users_on_page_1()
    {
        $response = $this->getJson('/api/users?page=1');
        $jsonResponse = json_decode($response->getContent(), true);

        $this->assertCount(6, $jsonResponse['users']);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    public function test_can_see_main_page_on_root(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Users');
        $response->assertViewIs('usersList');
    }

    public function test_can_see_main_page(): void
    {
        $response = $this->get('/users');

        $response->assertStatus(200);
        $response->assertSee('Users');
        $response->assertViewIs('usersList');
    }

    public function test_pagination_works_correctly()
    {
        DB::table('users')->truncate();
        User::factory()->count(12)->create();

        $response = $this->getJson('/api/users');
        $jsonResponse = json_decode($response->getContent(), true);

        $this->assertCount(10, $jsonResponse['users']['data']);
        $this->assertTrue(class_implements($jsonResponse['users']['data'], \Traversable::class));
    }

    public function test_can_see_create_page(): void
    {
        $response = $this->get('/users/create');

        $response->assertStatus(200);
        $response->assertSee('Create User');
        $response->assertViewIs('createUser');
    }

    public function test_can_get_user_data_by_id(): void
    {
        $response = $this->get('/users/2');

        $response->assertStatus(200);
        $response->assertSee('User');
        $response->assertViewIs('userData');
    }

    public function test_can_get_user_data_by_id_unit(): void
    {
        $response = $this->getJson('/api/users/2');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['email', 'first_name', 'last_name', 'avatar']]);
    }

    public function test_cant_get_nonexistent_user(): void
    {
        $response = $this->getJson('/api/users/23');

        $response
            ->assertStatus(404);
    }

    public function test_can_create_user()
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
}


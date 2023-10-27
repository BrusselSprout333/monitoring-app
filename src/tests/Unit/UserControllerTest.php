<?php

namespace Tests\Unit;

use App\Interfaces\ApiServiceInterface;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_get_user_by_id(): void
    {
        $this->mock(ApiServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('getUserById')
                ->once()
                ->with(2)
                ->andReturn(
                    new \Illuminate\Http\Client\Response(
                        new \GuzzleHttp\Psr7\Response(
                            body: json_encode(
                            [
                                'data' => [
                                    'id'         => 1,
                                    'email'      => 'mark_twen@gmail.com',
                                    'first_name' => 'Mark',
                                    'last_name'  => 'Twen',
                                    'avatar'     => 'image'
                                ]
                            ])
                        )
                    )
                );
        });

        $response = $this->getJson('/api/users/2');

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'email', 'first_name', 'last_name', 'avatar']);
    }

    public function test_cant_get_nonexistent_user_by_id(): void
    {
        $this->mock(ApiServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('getUserById')
                ->once()
                ->with(23)
                ->andReturn(
                    new \Illuminate\Http\Client\Response(
                        new \GuzzleHttp\Psr7\Response(404)
                    )
                );
        });

        $response = $this->getJson('/api/users/23');

        $response->assertStatus(404);
    }

    public function test_create_user()
    {
        $request = [
            'name' => 'Mark',
            'job'  => 'Manager'
        ];

        $this->mock(ApiServiceInterface::class, function (MockInterface $mock) use ($request) {
            $mock->shouldReceive('createUser')
                ->once()
                ->with($request)
                ->andReturn(
                    new \Illuminate\Http\Client\Response(
                        new \GuzzleHttp\Psr7\Response(
                            Response::HTTP_CREATED,
                            body: json_encode(
                            [
                                'data' => [
                                    'id'   => 1,
                                    'name' => $request['name'],
                                    'job'  => $request['job']
                                ]
                            ])
                        )
                    )
                );
        });

        $response = $this->postJson('/api/users', $request);

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['id']);
    }

    public function test_create_user_on_api_error()
    {
        $request = [
            'name' => 'Mark',
            'job'  => 'Manager'
        ];

        $this->mock(ApiServiceInterface::class, function (MockInterface $mock) use ($request) {
            $mock->shouldReceive('createUser')
                ->once()
                ->with($request)
                ->andReturn(
                    new \Illuminate\Http\Client\Response(
                        new \GuzzleHttp\Psr7\Response(
                            Response::HTTP_INTERNAL_SERVER_ERROR
                        )
                    )
                );
        });

        $response = $this->postJson('/api/users', $request);

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
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
        $this->mock(ApiServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('getAllUsers')
                ->once()
                ->andReturn(
                    new \Illuminate\Http\Client\Response(
                        new \GuzzleHttp\Psr7\Response(
                            body: file_get_contents(__DIR__ . '/data/users_data_part_page_1.json')
                        )
                    )
                );
        });

        $response = $this->getJson('/api/users?page=1');
        $jsonResponse = json_decode($response->getContent(), true);

        $this->assertCount(3, $jsonResponse['users']);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'users', 'hasMorePages', 'nextPage'
            ]);
    }

    public function test_get_all_users_on_page_1_on_api_error()
    {
        $this->mock(ApiServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('getAllUsers')
                ->once()
                ->andReturn(
                    new \Illuminate\Http\Client\Response(
                        new \GuzzleHttp\Psr7\Response(
                            Response::HTTP_INTERNAL_SERVER_ERROR
                        )
                    )
                );
        });

        $response = $this->getJson('/api/users?page=1');
        $jsonResponse = json_decode($response->getContent(), true);

        $this->assertEmpty($jsonResponse);
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

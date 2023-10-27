<?php

namespace Tests\Unit;

use App\Services\ApiService;
use Illuminate\Http\Client\Factory;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    public function test_get_all_users(): void
    {
        $apiService = new ApiService(new Factory());

        $response = $apiService->getAllUsers(2);

        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/users_page_2.json')),
            preg_replace('/\s+/', '', $response->body()));
    }

    public function test_get_user_by_id(): void
    {
        $apiService = new ApiService(new Factory());

        $response = $apiService->getUserById(2);

        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/user_2.json')),
            preg_replace('/\s+/', '', $response->body()));
    }

    public function test_create_user(): void
    {
        $apiService = new ApiService(new Factory());

        $response = $apiService->createUser(['name' => 'Jess', 'job' => 'Assistant']);

        $this->assertEquals(201, $response->status());
        $this->assertStringContainsString('"name":"Jess"', $response->body());
        $this->assertStringContainsString('"job":"Assistant"', $response->body());
        $this->assertStringContainsString('"id":', $response->body());
    }

    public function test_get_empty_users_page(): void
    {
        $apiService = new ApiService(new Factory());

        $response = $apiService->getAllUsers(3);

        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/users_page_3.json')),
            preg_replace('/\s+/', '', $response->body()));
    }

    public function test_get_nonexistent_user(): void
    {
        $apiService = new ApiService(new Factory());

        $response = $apiService->getUserById(23);

        $this->assertEquals(404, $response->status());
    }
}

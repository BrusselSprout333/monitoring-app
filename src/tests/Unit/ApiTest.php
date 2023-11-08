<?php

namespace Tests\Unit;

use App\GuzzleAdapter\Guzzle;
use App\Services\ApiService;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    public function testGetAllUsers(): void
    {
        $apiService = new ApiService(new Guzzle(new Client()));

        $response = $apiService->getAllUsers(2);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/users_page_2.json')),
            preg_replace('/\s+/', '', $response->getBody()->getContents()));
    }

    public function testGetUserById(): void
    {
        $apiService = new ApiService(new Guzzle(new Client()));

        $response = $apiService->getUserById(2);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/user_2.json')),
            preg_replace('/\s+/', '', $response->getBody()->getContents()));
    }

    public function testCreateUser(): void
    {
        $apiService = new ApiService(new Guzzle(new Client()));

        $response = $apiService->createUser(['name' => 'Jess', 'job' => 'Assistant']);
        $content = $response->getBody()->getContents();

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertStringContainsString('"name":"Jess"', $content);
        $this->assertStringContainsString('"job":"Assistant"', $content);
        $this->assertStringContainsString('"id":', $content);
    }

    public function testGetEmptyUsersPage(): void
    {
        $apiService = new ApiService(new Guzzle(new Client()));

        $response = $apiService->getAllUsers(3);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/users_page_3.json')),
            preg_replace('/\s+/', '', $response->getBody()->getContents()));
    }

    public function testGetNonexistentUser(): void
    {
        $apiService = new ApiService(new Guzzle(new Client()));

        $response = $apiService->getUserById(23);

        $this->assertEquals(404, $response->getStatusCode());
    }
}

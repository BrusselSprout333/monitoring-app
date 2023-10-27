<?php

namespace Tests\Unit;

use App\Interfaces\ApiServiceInterface;
use App\Services\ApiCacheProxy;
use App\Services\ApiService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Mockery\MockInterface;
use Tests\TestCase;

class ApiCacheProxyTest extends TestCase
{
    public function test_get_all_users_from_cache(): void
    {
        $apiService = $this->createMock(ApiService::class);
        $apiService->expects($this->never())->method('getAllUsers');

        Cache::shouldReceive('get')->andReturn(file_get_contents(__DIR__ . '/data/users_page_2.json'));

        $apiCacheProxy = new ApiCacheProxy($apiService);

        $response = $apiCacheProxy->getAllUsers(2);

        $this->assertEquals(200, $response->status());
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/users_page_2.json')),
            preg_replace('/\s+/', '', $response->body()));
    }

    public function test_get_all_users_from_origin(): void
    {
        $apiService = $this->createMock(ApiService::class);
        $apiService->expects($this->once())
            ->method('getAllUsers')
            ->with(2)
            ->willReturn(new \Illuminate\Http\Client\Response(
                new \GuzzleHttp\Psr7\Response(
                    body: file_get_contents(__DIR__ . '/data/users_page_2.json')
                )
            ));

        Cache::shouldReceive('get')->andReturn(null);
        Cache::shouldReceive('put')->with('api:cache:users:page:2', file_get_contents(__DIR__ . '/data/users_page_2.json'), 20);

        $apiCacheProxy = new ApiCacheProxy($apiService);

        $response = $apiCacheProxy->getAllUsers(2);

        $this->assertEquals(200, $response->status());
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/users_page_2.json')),
            preg_replace('/\s+/', '', $response->body()));
    }

    public function test_get_user_by_id_from_cache(): void
    {
        $apiService = $this->createMock(ApiService::class);
        $apiService->expects($this->never())->method('getUserById');

        Cache::shouldReceive('get')->andReturn(file_get_contents(__DIR__ . '/data/user_2.json'));

        $apiCacheProxy = new ApiCacheProxy($apiService);

        $response = $apiCacheProxy->getUserById(2);

        $this->assertEquals(200, $response->status());
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/user_2.json')),
            preg_replace('/\s+/', '', $response->body()));
    }

    public function test_get_user_bu_id_from_origin(): void
    {
        $apiService = $this->createMock(ApiService::class);
        $apiService->expects($this->once())
            ->method('getUserById')
            ->with(2)
            ->willReturn(new \Illuminate\Http\Client\Response(
                new \GuzzleHttp\Psr7\Response(
                    body: file_get_contents(__DIR__ . '/data/user_2.json')
                )
            ));

        Cache::shouldReceive('get')->andReturn(null);
        Cache::shouldReceive('put')->with('api:cache:users:2', file_get_contents(__DIR__ . '/data/user_2.json'), 20);

        $apiCacheProxy = new ApiCacheProxy($apiService);

        $response = $apiCacheProxy->getUserById(2);

        $this->assertEquals(200, $response->status());
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/user_2.json')),
            preg_replace('/\s+/', '', $response->body()));
    }

}

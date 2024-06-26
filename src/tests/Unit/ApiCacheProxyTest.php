<?php

namespace Tests\Unit;

use App\Cache\Cache;
use App\Services\ApiCacheProxy;
use App\Services\ApiService;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

class ApiCacheProxyTest extends TestCase
{
    public function testGetAllUsersFromCache(): void
    {
        $apiService = $this->createMock(ApiService::class);
        $apiService->expects($this->never())->method('getAllUsers');

        $cache = $this->createMock(Cache::class);
        $cache->expects($this->once())
            ->method('get')
            ->with('api:cache:users:page:2')
            ->willReturn(file_get_contents(__DIR__ . '/data/users_page_2.json'));

        $apiCacheProxy = new ApiCacheProxy($apiService, $cache);

        $response = $apiCacheProxy->getAllUsers(2);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/users_page_2.json')),
            preg_replace('/\s+/', '', $response->getBody()->getContents()));
    }

    public function testGetAllUsersFromOrigin(): void
    {
        $apiService = $this->createMock(ApiService::class);
        $apiService->expects($this->once())
            ->method('getAllUsers')
            ->with(2)
            ->willReturn(new \GuzzleHttp\Psr7\Response(
                    body: file_get_contents(__DIR__ . '/data/users_page_2.json')
                )
            );

        $cache = $this->createMock(Cache::class);
        $cache->expects($this->once())
            ->method('get')
            ->with('api:cache:users:page:2')
            ->willReturn(null);

        $cache->expects($this->once())
            ->method('set')
            ->with('api:cache:users:page:2', file_get_contents(__DIR__ . '/data/users_page_2.json'), 20)
            ->willReturn(true);

        $apiCacheProxy = new ApiCacheProxy($apiService, $cache);

        $response = $apiCacheProxy->getAllUsers(2);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/users_page_2.json')),
            preg_replace('/\s+/', '', $response->getBody()->getContents()));
    }

    public function testGetUserByIdFromCache(): void
    {
        $apiService = $this->createMock(ApiService::class);
        $apiService->expects($this->never())->method('getUserById');

        $cache = $this->createMock(Cache::class);
        $cache->expects($this->once())
            ->method('get')
            ->with('api:cache:users:2')
            ->willReturn(file_get_contents(__DIR__ . '/data/user_2.json'));

        $apiCacheProxy = new ApiCacheProxy($apiService, $cache);

        $response = $apiCacheProxy->getUserById(2);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/user_2.json')),
            preg_replace('/\s+/', '', $response->getBody()->getContents()));
    }

    public function testGetUserByIdFromOrigin(): void
    {
        $apiService = $this->createMock(ApiService::class);
        $apiService->expects($this->once())
            ->method('getUserById')
            ->with(2)
            ->willReturn(new \GuzzleHttp\Psr7\Response(
                    body: file_get_contents(__DIR__ . '/data/user_2.json')
                )
            );

        $cache = $this->createMock(Cache::class);
        $cache->expects($this->once())
            ->method('get')
            ->with('api:cache:users:2')
            ->willReturn(null);

        $cache->expects($this->once())
            ->method('set')
            ->with('api:cache:users:2', file_get_contents(__DIR__ . '/data/user_2.json'), 20)
            ->willReturn(true);

        $apiCacheProxy = new ApiCacheProxy($apiService, $cache);

        $response = $apiCacheProxy->getUserById(2);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(
            preg_replace('/\s+/', '', file_get_contents(__DIR__ . '/data/user_2.json')),
            preg_replace('/\s+/', '', $response->getBody()->getContents()));
    }
}

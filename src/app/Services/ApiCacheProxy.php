<?php

namespace App\Services;

use App\Interfaces\ApiServiceInterface;
use Illuminate\Http\Client\Response;
use Psr\SimpleCache\CacheInterface;

class ApiCacheProxy implements ApiServiceInterface
{
    private const CACHE_PREFIX = 'api:cache:users:';

    public function __construct(
        private readonly ApiService $apiService,
        private readonly CacheInterface $cache
    ) {
    }

    public function getAllUsers($page): Response
    {
        $cacheKey = $this::CACHE_PREFIX . 'page:' . $page;

        $cachedResponseBody = $this->cache->get($cacheKey);

        if($cachedResponseBody) {
            return new Response(new \GuzzleHttp\Psr7\Response(body: $cachedResponseBody));
        }

        $originalResponse = $this->apiService->getAllUsers($page);

        $this->cache->set($cacheKey, $originalResponse->body(), 20);

        return $originalResponse;
    }

    public function getUserById(int $id): Response
    {
        $cacheKey = $this::CACHE_PREFIX . $id;

        $cachedResponseBody = $this->cache->get($cacheKey);

        if($cachedResponseBody) {
            return new Response(new \GuzzleHttp\Psr7\Response(body: $cachedResponseBody));
        }

        $originalResponse = $this->apiService->getUserById($id);

        $this->cache->set($cacheKey, $originalResponse->body(), 20);

        return $originalResponse;
    }

    public function createUser(array $params): Response
    {
        return $this->apiService->createUser($params);
    }
}

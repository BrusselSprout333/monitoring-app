<?php

namespace App\Services;

use App\Interfaces\ApiServiceInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;

class ApiCacheProxy implements ApiServiceInterface
{
    protected const CACHE_PREFIX = 'api:cache:users:';

    public function __construct(protected ApiService $apiService)
    {
    }

    public function getAllUsers($page): Response
    {
        $cacheKey = $this::CACHE_PREFIX . 'page:' . $page;

        $cachedResponseBody = Cache::get($cacheKey);

        if($cachedResponseBody) {
            return new Response(new \GuzzleHttp\Psr7\Response(body: $cachedResponseBody));
        }

        $originalResponse = $this->apiService->getAllUsers($page);

        Cache::put($cacheKey, $originalResponse->body(), 20);

        return $originalResponse;
    }

    public function getUserById(int $id): Response
    {
        $cacheKey = $this::CACHE_PREFIX . $id;

        $cachedResponseBody = Cache::get($cacheKey);

        if($cachedResponseBody) {
            return new Response(new \GuzzleHttp\Psr7\Response(body: $cachedResponseBody));
        }

        $originalResponse = $this->apiService->getUserById($id);

        Cache::put($cacheKey, $originalResponse->body(), 20);

        return $originalResponse;
    }

    public function createUser(array $params): Response
    {
        return $this->apiService->createUser($params);
    }
}

<?php

namespace App\Services;

use App\Interfaces\ApiServiceInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;

class ApiCacheProxy implements ApiServiceInterface
{
    private const CACHE_PREFIX = 'api:cache:users:';
    private const CACHE_TTL = 20;

    public function __construct(
        private readonly ApiService $apiService,
        private readonly CacheInterface $cache
    ) {
    }

    public function getAllUsers($page): ResponseInterface
    {
        $cacheKey = $this::CACHE_PREFIX . 'page:' . $page;

        $cachedResponseBody = $this->cache->get($cacheKey);

        if($cachedResponseBody) {
            return new Response(body: $cachedResponseBody);
        }

        $originalResponse = $this->apiService->getAllUsers($page);
        $responseData = $originalResponse->getBody()->getContents();

        if($originalResponse->getStatusCode() === 200) {
            $this->cache->set($cacheKey, $responseData, $this::CACHE_TTL);
        }

        return new Response($originalResponse->getStatusCode(), body: $responseData);
    }

    public function getUserById(int $id): ResponseInterface
    {
        $cacheKey = $this::CACHE_PREFIX . $id;

        $cachedResponseBody = $this->cache->get($cacheKey);

        if($cachedResponseBody) {
            return new Response(body: $cachedResponseBody);
        }

        $originalResponse = $this->apiService->getUserById($id);
        $responseData = $originalResponse->getBody()->getContents();

        if($originalResponse->getStatusCode() === 200) {
            $this->cache->set($cacheKey, $responseData, $this::CACHE_TTL);
        }

        return new Response($originalResponse->getStatusCode(), body: $responseData);
    }

    public function createUser(array $params): ResponseInterface
    {
        return $this->apiService->createUser($params);
    }
}

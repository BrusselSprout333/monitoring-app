<?php

namespace App\Services;

use App\Interfaces\ApiServiceInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class ApiErrorHandlingProxy implements ApiServiceInterface
{
    public function __construct(protected ApiCacheProxy $apiService)
    {
    }

    public function getAllUsers(int $page): Response
    {
        try {
            return $this->apiService->getAllUsers($page);
        } catch (\Exception $e) {
            Log::critical('Error calling external API: ' . $e->getMessage());

            return new Response(new \GuzzleHttp\Psr7\Response(500));
        }
    }

    public function getUserById(int $id): Response
    {
        try {
            return $this->apiService->getUserById($id);
        } catch (\Exception $e) {
            Log::critical('Error calling external API: ' . $e->getMessage());

            return new Response(new \GuzzleHttp\Psr7\Response(500));
        }
    }

    public function createUser(array $params): Response
    {
        try {
            return $this->apiService->createUser($params);
        } catch (\Exception $e) {
            Log::critical('Error calling external API: ' . $e->getMessage());

            return new Response(new \GuzzleHttp\Psr7\Response(500));
        }
    }
}

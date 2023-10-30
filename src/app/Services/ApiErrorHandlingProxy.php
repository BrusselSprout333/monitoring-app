<?php

namespace App\Services;

use App\Interfaces\ApiServiceInterface;
use App\Logger\Logger;
use Illuminate\Http\Client\Response;

class ApiErrorHandlingProxy implements ApiServiceInterface
{
    public function __construct(
        private readonly ApiCacheProxy $apiService,
        private readonly Logger $logger
    ) {
    }

    public function getAllUsers(int $page): Response
    {
        try {
            return $this->apiService->getAllUsers($page);
        } catch (\Exception $e) {
            $this->logger->critical('Error calling external API: ' . $e->getMessage());

            return new Response(new \GuzzleHttp\Psr7\Response(500));
        }
    }

    public function getUserById(int $id): Response
    {
        try {
            return $this->apiService->getUserById($id);
        } catch (\Exception $e) {
            $this->logger->critical('Error calling external API: ' . $e->getMessage());

            return new Response(new \GuzzleHttp\Psr7\Response(500));
        }
    }

    public function createUser(array $params): Response
    {
        try {
            return $this->apiService->createUser($params);
        } catch (\Exception $e) {
            $this->logger->critical('Error calling external API: ' . $e->getMessage());

            return new Response(new \GuzzleHttp\Psr7\Response(500));
        }
    }
}

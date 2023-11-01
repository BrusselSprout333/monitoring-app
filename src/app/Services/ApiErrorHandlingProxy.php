<?php

namespace App\Services;

use App\Interfaces\ApiServiceInterface;
use App\Logger\Logger;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;

class ApiErrorHandlingProxy implements ApiServiceInterface
{
    public function __construct(
        private readonly ApiCacheProxy $apiService,
        private readonly Logger $logger
    ) {
    }

    public function getAllUsers(int $page): ResponseInterface
    {
        try {
            return $this->apiService->getAllUsers($page);
        } catch (\Throwable $e) {
            $this->logger->critical('Error calling external API: ' . $e->getMessage());

            return new Response(ResponseCodes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserById(int $id): ResponseInterface
    {
        try {
            return $this->apiService->getUserById($id);
        } catch (\Throwable $e) {
            $this->logger->critical('Error calling external API: ' . $e->getMessage());

            return new Response(ResponseCodes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createUser(array $params): ResponseInterface
    {
        try {
            return $this->apiService->createUser($params);
        } catch (\Throwable $e) {
            $this->logger->critical('Error calling external API: ' . $e->getMessage());

            return new Response(ResponseCodes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

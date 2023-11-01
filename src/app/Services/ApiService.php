<?php

namespace App\Services;

use App\Interfaces\ApiServiceInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class ApiService implements ApiServiceInterface
{
    private string $apiUrl = 'https://reqres.in/api/users';

    public function __construct(protected ClientInterface $client)
    {
    }

    public function getAllUsers(int $page): ResponseInterface
    {
        return $this->client->sendRequest(new Request('GET', $this->apiUrl . '?page=' . $page));
    }

    public function getUserById(int $id): ResponseInterface
    {
        return $this->client->sendRequest(new Request('GET', $this->apiUrl . '/' . $id));
    }

    public function createUser(array $params): ResponseInterface
    {
        return $this->client->sendRequest(new Request('POST', $this->apiUrl, [
                'Content-Type' => 'application/json',
            ], json_encode($params))
        );
    }
}

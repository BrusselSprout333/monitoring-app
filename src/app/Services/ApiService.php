<?php

namespace App\Services;

use App\Interfaces\ApiServiceInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\Factory as HttpClient;

class ApiService implements ApiServiceInterface
{
    private string $apiUrl = 'https://reqres.in/api/users';

    public function __construct(protected HttpClient $httpClient)
    {
    }

    public function getAllUsers(int $page): Response
    {
        return $this->httpClient->get($this->apiUrl . '?page=' . $page);
    }

    public function getUserById(int $id): Response
    {
        return $this->httpClient->get($this->apiUrl . '/' . $id);
    }

    public function createUser(array $params): Response
    {
        return $this->httpClient->post($this->apiUrl, $params);
    }
}

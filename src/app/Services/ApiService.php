<?php

namespace App\Services;

use App\Interfaces\ApiServiceInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ApiService implements ApiServiceInterface
{
    private string $apiUrl = 'https://reqres.in/api/users';

    public function getAllUsers(int $page): Response
    {
        return Http::get($this->apiUrl . '?page=' . $page);
    }

    public function getUserById(int $id): Response
    {
        return Http::get($this->apiUrl . '/' . $id);
    }

    public function createUser(array $params): Response
    {
        return Http::get($this->apiUrl, $params);
    }
}

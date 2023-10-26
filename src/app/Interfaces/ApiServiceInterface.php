<?php

namespace App\Interfaces;

use Illuminate\Http\Client\Response;

interface ApiServiceInterface
{
    public function getAllUsers(int $page): Response;

    public function getUserById(int $id): Response;

    public function createUser(array $params): Response;
}

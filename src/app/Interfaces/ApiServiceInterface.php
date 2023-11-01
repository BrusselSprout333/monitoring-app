<?php

namespace App\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface ApiServiceInterface
{
    public function getAllUsers(int $page): ResponseInterface;

    public function getUserById(int $id): ResponseInterface;

    public function createUser(array $params): ResponseInterface;
}

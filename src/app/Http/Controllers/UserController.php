<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    private string $apiUrl = 'https://reqres.in/api/users';

    public function create(StoreUserRequest $request): JsonResponse
    {
        $name = $request->getName();
        $job = $request->getJob();

        $response = Http::post($this->apiUrl, [
            'name' => $name,
            'job' => $job
        ]);

        return new JsonResponse(['id' => $response->json('id')], 201);
    }

    public function getAll()
    {
        $response = Http::get($this->apiUrl);

        return $response->json();
    }

    public function getById(int $id)
    {
        $response = Http::get($this->apiUrl . '/' . $id);

        return $response->json();
    }
}

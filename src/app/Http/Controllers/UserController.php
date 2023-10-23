<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

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

    public function getAll(): JsonResponse
    {
        $response = Http::get($this->apiUrl);

        return $response->json();
    }

    public function getById(int $id): JsonResponse
    {
        $response = Http::get($this->apiUrl . '/' . $id);

        if ($response->successful()) {
            $userData = $response->json();
            return new JsonResponse($userData, Response::HTTP_OK);
        } else {
            return new JsonResponse(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
    }
}

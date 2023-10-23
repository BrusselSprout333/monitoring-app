<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

        return new JsonResponse(['id' => $response->json('id')], Response::HTTP_CREATED);
    }

    public function getAll(Request $request): JsonResponse
    {
        $page = $request->query('page');

        $response = Http::get($this->apiUrl . '?page=' . $page);

        return new JsonResponse($response->json(), Response::HTTP_OK);
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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Interfaces\ApiServiceInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ds\Collection;
use Ds\Set;

class UserController extends Controller
{
    public function __construct(protected ApiServiceInterface $apiService)
    {
    }

    public function create(StoreUserRequest $request): JsonResponse
    {
        $userData = [
            'name' => $request->getName(),
            'job' => $request->getJob(),
        ];

        $response = $this->apiService->createUser($userData);

        if (!$this->isSuccessful($response->getStatusCode())) {
            return response()->json(status: $response->getStatusCode());
        }

        $responseContent = $response->getBody()->getContents();

        return response()->json(['id' => (int)json_decode($responseContent)->id], $response->getStatusCode());
    }

    public function getAll(Request $request): JsonResponse
    {
        $page = $request->query('page');

        $response = $this->apiService->getAllUsers($page);

        if (!$this->isSuccessful($response->getStatusCode())) {
            return response()->json(status: $response->getStatusCode());
        }

        $responseContent = $response->getBody()->getContents();
        $usersData = json_decode($responseContent)->data;
        $lastPage = json_decode($responseContent)->total_pages;

        $collection = $this->collectUsers($usersData);
        $paginatedCollection = $this->paginateUsers($collection, $page, $lastPage);

        return response()->json($paginatedCollection);
    }

    public function getById(int $id): JsonResponse
    {
        $response = $this->apiService->getUserById($id);

        if (!$this->isSuccessful($response->getStatusCode())) {
            return response()->json(status: $response->getStatusCode());
        }

        $responseContent = $response->getBody()->getContents();
        $userData = get_object_vars(json_decode($responseContent)->data);

        $user = new User($userData);

        return response()->json($user->jsonSerialize());
    }

    private function collectUsers(iterable $users): Collection
    {
        return new Set($users);
    }

    private function paginateUsers(Collection $users, int $page, int $lastPage): array
    {
        return [
            'users' => $users->jsonSerialize(),
            'hasMorePages' => $page < $lastPage,
            'nextPage' => $page + 1
        ];
    }

    private function isSuccessful(int $status): bool
    {
        return $status >= 200 && $status < 300;
    }
}

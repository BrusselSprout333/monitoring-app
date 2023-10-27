<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Interfaces\ApiServiceInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public function __construct(protected ApiServiceInterface $apiService)
    {
    }

    public function create(StoreUserRequest $request): JsonResponse
    {
        $name = $request->getName();
        $job = $request->getJob();

        $response = $this->apiService->createUser([
            'name' => $name,
            'job' => $job
        ]);

        if (!$response->successful()) {
            return response()->json(status: $response->status());
        }

        return response()->json(['id' => $response->json('id')], $response->status());
    }

    public function getAll(Request $request): JsonResponse
    {
        $page = $request->query('page');

        $response = $this->apiService->getAllUsers($page);

        if (!$response->successful()) {
            return response()->json(status: $response->status());
        }

        $usersData = $response->json()['data'];
        $lastPage = $response->json()['total_pages'];

        $collection = $this->collectUsers($usersData);
        $paginatedCollection = $this->paginateUsers($collection, $page, $lastPage);

        return response()->json($paginatedCollection);
    }

    public function getById(int $id): JsonResponse
    {
        $response = $this->apiService->getUserById($id);

        if (!$response->successful()) {
            return response()->json(status: $response->status());
        }

        $userData = $response->json()['data'];

        $user = new User($userData);

        return response()->json($user->jsonSerialize());
    }

    private function collectUsers(array $users): Collection
    {
        return collect($users)->map(function ($user) {
            return new User($user);
        });
    }

    private function paginateUsers(Collection $users, int $page, int $lastPage): array
    {
        return [
            'users' => $users->jsonSerialize(),
            'hasMorePages' => $page < $lastPage,
            'nextPage' => $page + 1
        ];
    }
}

<?php

namespace App\Http\Controllers;

use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Interfaces\UserRepositoryInterface;

class UsersController extends Controller
{
    use ApiResponseHelpers;

    public function __construct(private readonly UserRepositoryInterface $userRepository) {}

    public function index(): JsonResponse
    {
        $users = $this->userRepository->getAllUsers();

        return $this->respondWithSuccess(new UserCollection($users));
    }

    public function store(UserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = $this->userRepository->storeUser($validated);

        return $this->respondCreated(new UserResource($user));
    }

    public function show($id): JsonResponse
    {
        $user = $this->userRepository->getUserById($id);

        return $this->respondWithSuccess(new UserResource($user));
    }

    public function update(UserRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();

        return $this->respondWithSuccess($this->userRepository->updateUser($id, $validated));
    }

    public function destroy($id): JsonResponse
    {
         $this->userRepository->deleteUser($id);

         return $this->respondNoContent();
    }
}

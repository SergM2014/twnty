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

    /**
     * @OA\Get(
     *   path="/api/users",
     *   summary="list users",
     *   operationId="listUsers",
     *   tags={"users"},
     *   @OA\Response(
     *      response=200,
     *      description="successful operation",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/User")
     *      ),
     *      @OA\XmlContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/User")
     *      )
     *     ),
     *   @OA\Response(
     *     response="500",
     *     description="unexpected error"
     *   )
     * )
     */
    public function index(): JsonResponse
    {
        $users = $this->userRepository->getAllUsers();

        return $this->respondWithSuccess(new UserCollection($users));
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Create a user",
     *     operationId="createUser",
     *     tags={"users"},
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="role",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           default="user",
     *           type="string",
     *           enum={"user", "moderator", "admin"},
     *      )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Success",
     *     @OA\JsonContent(
     *        type="object", ref="#/components/schemas/User",
     *     )
     *  ),
     *     @OA\Response(
     *       response=422,
     *       description="uprocessable content"
     *   ),
     *     @OA\Response(
     *         response="500",
     *         description="unexpected error"
     *     )
     * )
     */
    public function store(UserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = $this->userRepository->storeUser($validated);

        return $this->respondCreated(new UserResource($user));
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     description="Returns a user based on a single ID",
     *     operationId="findUserById",
     *     summary="Get a user",
     *     tags={"users"},
     *     @OA\Parameter(
     *         description="ID of user to fetch",
     *         in="path",
     *         name="id",
     *         required=true,
     *     ),
     *   @OA\Response(
     *     response=200,
     *     description="show user",
     *     @OA\JsonContent(
     *        type="object", ref="#/components/schemas/User"),
     *  ),
     *     @OA\Response(
     *         response="500",
     *         description="unexpected error",
     *     ),
     *      @OA\Response(
     *         response="404",
     *         description="not found user error",
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $user = $this->userRepository->getUserById($id);

        return $this->respondWithSuccess(new UserResource($user));
    }

    /**
     * @OA\Put(
     *     path="/api/users/{userId}",
     *     summary="Update a user",
     *     operationId="updateUser",
     *     tags={"users"},
     *     @OA\Parameter(
     *         description="ID of user to update",
     *         in="path",
     *         name="userId",
     *         required=true,
     *     ),
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="role",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           default="user",
     *           type="string",
     *           enum={"user", "moderator", "admin"},
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Post updated",
     *     @OA\JsonContent(
     *        type="object", ref="#/components/schemas/User"),
     *  ),
     *   @OA\Response(
     *       response=422,
     *       description="uprocessable content"
     *   ),
     *     @OA\Response(
     *         response="500",
     *         description="unexpected error"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="not found user error",
     *     )
     * )
     */
    public function update(UserRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();

        return $this->respondWithSuccess($this->userRepository->updateUser($id, $validated));
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     description="deletes a single user based on the ID supplied",
     *     operationId="deleteUser",
     *     summary="Delete a User",
     *     tags={"users"},
     *     @OA\Parameter(
     *         description="ID of user to delete",
     *         in="path",
     *         name="id",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="user deleted"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="unexpected error"
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
         $this->userRepository->deleteUser($id);

         return $this->respondNoContent();
    }
}

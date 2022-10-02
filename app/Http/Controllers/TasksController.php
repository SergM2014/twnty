<?php

namespace App\Http\Controllers;

use F9Web\ApiResponseHelpers;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;
use App\Interfaces\TaskRepositoryInterface;

class TasksController extends Controller
{
    use ApiResponseHelpers;

    public function __construct(private readonly TaskRepositoryInterface $taskRepository) {}

    /**
     * @OA\Get(
     *   path="/api/tasks",
     *   summary="list tasks",
     *   operationId="listTasks",
     *   tags={"tasks"},
     *   @OA\Response(
     *      response=200,
     *      description="successful operation",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Task")
     *      ),
     *      @OA\XmlContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Task")
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
        $tasks = $this->taskRepository->getAllTasks();

        return $this->respondWithSuccess(new TaskCollection($tasks));
    }
    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Create a task",
     *     operationId="createTask",
     *     tags={"tasks"},
     *  @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="executor",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Success",
     *     @OA\JsonContent(
     *        type="object", ref="#/components/schemas/Task",
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
    public function store(TaskRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $task = $this->taskRepository->storeTask($validated);

        return $this->respondCreated(new TaskResource($task));
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     description="Returns a task based on a single ID",
     *     operationId="findTaskById",
     *     summary="Get a Task",
     *     tags={"tasks"},
     *     @OA\Parameter(
     *         description="ID of task to fetch",
     *         in="path",
     *         name="id",
     *         required=true,
     *     ),
     *   @OA\Response(
     *     response=200,
     *     description="show task",
     *     @OA\JsonContent(
     *        type="object", ref="#/components/schemas/Task"),
     *  ),
     *     @OA\Response(
     *         response="500",
     *         description="unexpected error",
     *     ),
     *      @OA\Response(
     *         response="404",
     *         description="not found task error",
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $task = $this->taskRepository->getTaskById($id);

        return $this->respondWithSuccess(new TaskResource($task));
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{taskId}",
     *     summary="Update a task",
     *     operationId="updateTask",
     *     tags={"tasks"},
     *     @OA\Parameter(
     *         description="ID of task to update",
     *         in="path",
     *         name="taskId",
     *         required=true,
     *     ),
     *  @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="executor",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Task updated",
     *     @OA\JsonContent(
     *        type="object", ref="#/components/schemas/Task"),
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
     *         description="not found task error",
     *     )
     * )
     */
    public function update(TaskRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();

        return $this->respondWithSuccess($this->taskRepository->updateTask($id, $validated));
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     description="deletes a single task based on the ID supplied",
     *     operationId="deleteTask",
     *     summary="Delete a Task",
     *     tags={"tasks"},
     *     @OA\Parameter(
     *         description="ID of task to delete",
     *         in="path",
     *         name="id",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="task deleted"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="unexpected error"
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        $this->taskRepository->deleteTask($id);

        return $this->respondNoContent();
    }
}

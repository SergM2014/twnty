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

    public function index(): JsonResponse
    {
        $tasks = $this->taskRepository->getAllTasks();

        return $this->respondWithSuccess(new TaskCollection($tasks));
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $task = $this->taskRepository->storeTask($validated);

        return $this->respondCreated(new TaskResource($task));
    }

    public function show($id): JsonResponse
    {
        $task = $this->taskRepository->getTaskById($id);

        return $this->respondWithSuccess(new TaskResource($task));
    }

    public function update(TaskRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();

        return $this->respondWithSuccess($this->taskRepository->updateTask($id, $validated));
    }

    public function destroy($id): JsonResponse
    {
        $this->taskRepository->deleteTask($id);

        return $this->respondNoContent();
    }
}

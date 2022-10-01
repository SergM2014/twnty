<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TaskCollection;
use App\Interfaces\TaskRepositoryInterface;

class SearchController extends Controller
{
    use ApiResponseHelpers;

    public function __construct(private readonly TaskRepositoryInterface $taskRepository) {}

    public function __invoke(Request $request): JsonResponse
    {
        $tasks = $this->taskRepository->search();

        return $this->respondWithSuccess(new TaskCollection($tasks));
    }
}

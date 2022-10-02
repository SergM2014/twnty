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

    /**
     * @OA\Get(
     *     path="/api/search",
     *     summary="Serching Tasks",
     *     operationId="searchTasks",
     *     tags={"search"},
     *     @OA\Parameter(
     *         in="query",
     *         name="status",
     *         @OA\Schema(
     *           type="string"
     *      )
     *     ),
     *      @OA\Parameter(
     *         in="query",
     *         name="executor",
     *         @OA\Schema(
     *           type="string"
     *      )
     *     ),
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
    public function __invoke(Request $request): JsonResponse
    {
        $tasks = $this->taskRepository->search();

        return $this->respondWithSuccess(new TaskCollection($tasks));
    }
}

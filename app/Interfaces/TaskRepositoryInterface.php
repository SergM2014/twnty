<?php

namespace App\Interfaces;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function getAllTasks(): Collection;
    public function getTaskById(int $id): Task;
    public function deleteTask(int $id): bool;
    public function storeTask(array $userProperties): Task;
    public function updateTask(int $id, array $newProperties): Task;
    public function search(): Collection;
}

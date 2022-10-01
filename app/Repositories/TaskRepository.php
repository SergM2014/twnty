<?php

namespace App\Repositories;

use App\Models\Task;
use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllTasks(): Collection
    {
        return Task::all();
    }

    public function getTaskById(int $id): Task
    {
        return Task::findOrFail($id);
    }

    public function deleteTask(int $id): bool
    {
        $task = Task::findOrFail($id);
        return  $task->delete();
    }

    public function storeTask(array $validated): Task
    {
        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'executor' => $validated['executor']
        ]);

        return $task;
    }

    public function updateTask(int $id, array $validated): Task
    {
        $task = Task::findOrFail($id);
        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->status = $validated['status'];
        $task->executor = $validated['executor'];
        $task->save();

        return $task;
    }

    public function search(): Collection
    {
        $status = request('status');
        $executor = request('executor');

        if($status){
                $tasks = Task::where('status', $status )->get();
            } else {
                $tasks = Task::all();
            }
        if($executor) {
            $executorNameTasks = $tasks->filter(fn ($task) =>
                $task->user()->where('name', 'like', '%'.$executor.'%')->first()
            );
        }

        return $executorNamesTasks ??= $tasks;
    }
}

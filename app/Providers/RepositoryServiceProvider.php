<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\TaskRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\TaskRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

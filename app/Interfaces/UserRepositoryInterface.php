<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getAllUsers(): Collection;
    public function getUserById(int $id): User;
    public function deleteUser(int $id): bool;
    public function storeUser(array $userProperties): User;
    public function updateUser(int $id, array $newProperties): User;
}

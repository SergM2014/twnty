<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers(): Collection
    {
        return User::all();
    }

    public function getUserById(int $id): User
    {
        return User::findOrFail($id);
    }

    public function deleteUser(int $id): bool
    {
        $user = User::findOrFail($id);

        return  $user->delete();
    }

    public function storeUser(array $validated): User
    {
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role']
        ]);

        return $user;
    }

    public function updateUser(int $id, array $validated): User
    {
        $user = User::findOrFail($id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = $validated['password'];
        $user->role = $validated['role'];
        $user->save();
        return $user;
    }
}

<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 *
 * @OA\Schema(
 * required={"name", "email", "password", "role"},
 * @OA\Xml(name="User"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", description="User name", example="random name"),
 * @OA\Property(property="email", type="string", description="User email", example="myemail@example.com"),
 * @OA\Property(property="password", type="string",  description="User password", example="password"),
 * @OA\Property(property="role", type="string", description="User role", example="admin"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * )
 *
 * Class User
 *
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    public function setPasswordAttributes($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

}

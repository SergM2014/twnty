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
 * @OA\Property(property="name", type="string", readOnly="true", description="User name"),
 * @OA\Property(property="email", type="string", readOnly="true",  description="User email"),
 * @OA\Property(property="password", type="string", readOnly="true",  description="User password"),
 * @OA\Property(property="role", type="string", readOnly="true", description="User role"),
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

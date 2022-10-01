<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userIds = User::pluck('id')->toArray();
        return [
            'title' => fake()->sentence(),
            'description' => fake()->sentences(3, true),
            'status' => fake()->randomElement(['new', 'processing', 'checking', 'completed']),
            'executor' => fake()->randomElement($userIds),
            'created_at' => fake()->dateTimeBetween('-3 day'),
            'updated_at' => fake()->dateTimeBetween('-3 day'),
        ];
    }
}

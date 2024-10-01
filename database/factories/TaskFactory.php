<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\Project;
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
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'creator_id' => User::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'due_date' => fake()->dateTimeBetween('now', '+1 month'),
            'status' => fake()->randomElement(TaskStatus::cases()),
        ];
    }

    public function asNew()
    {
        return $this->state([
            'status' => TaskStatus::NEW,
        ]);
    }

    public function inProgress()
    {
        return $this->state([
            'status' => TaskStatus::IN_PROGRESS,
        ]);
    }

    public function completed()
    {
        return $this->state([
            'status' => TaskStatus::COMPLETED,
        ]);
    }
}

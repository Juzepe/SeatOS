<?php

namespace Tests\Feature\Api\Tasks;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

test('user can edit a task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'title' => 'Original title',
        'description' => 'Original description',
        'due_date' => now()->addDays(7)->format('Y-m-d'),
    ]);
    $project = Project::factory()->create();

    $response = $this->actingAs($user)
        ->withHeaders([
            'Accept' => 'application/json',
        ])
        ->putJson("/api/tasks/{$task->id}", [
            'project_id' => $project->id,
            'title' => 'Updated title',
            'description' => 'Updated description',
            'due_date' => now()->addDays(14)->format('Y-m-d'),
        ]);

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Task updated successfully.',
    ]);

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'project_id' => $project->id,
        'title' => 'Updated title',
        'description' => 'Updated description',
        'due_date' => now()->addDays(14)->format('Y-m-d'),
    ]);
});

<?php

use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;

test('user can create task', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/tasks', [
        'project_id' => $project->id,
        'title' => 'Test task',
        'description' => 'Test description',
        'due_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'message' => 'Task created successfully.',
        ]);

    $this->assertDatabaseHas('tasks', [
        'project_id' => $project->id,
        'title' => 'Test task',
        'description' => 'Test description',
        'due_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
        'status' => TaskStatus::NEW,
    ]);
});

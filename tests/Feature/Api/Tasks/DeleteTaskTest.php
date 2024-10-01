<?php

namespace Tests\Feature\Api\Tasks;

use App\Models\Task;
use App\Models\User;

test('user can delete a task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create();

    $response = $this->actingAs($user)
        ->withHeaders([
            'Accept' => 'application/json',
        ])
        ->deleteJson("/api/tasks/{$task->id}");

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Task deleted successfully.',
    ]);

    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});

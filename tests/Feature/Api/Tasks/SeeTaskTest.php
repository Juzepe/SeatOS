<?php

namespace Tests\Feature\Api\Tasks;

use App\Models\Task;
use App\Models\User;

test('user can see a task', function () {
    $user = User::factory()->create();
    $creator = User::factory()->create([
        'name' => 'John',
        'surname' => 'Doe',
        'email' => 'john@example.com',
    ]);
    $task = Task::factory()->create([
        'creator_id' => $creator->id,
        'title' => 'Test task',
        'description' => 'Test description',
        'due_date' => now()->addDays(7)->format('Y-m-d'),
    ]);

    $response = $this->actingAs($user)
        ->withHeaders([
            'Accept' => 'application/json',
        ])
        ->getJson("/api/tasks/$task->id");

    $response->assertStatus(200)
        ->assertJson([
            'id' => $task->id,
            'title' => 'Test task',
            'description' => 'Test description',
            'due_date' => now()->addDays(7)->format('Y-m-d'),
            'creator' => [
                'id' => $creator->id,
                'name' => 'John',
                'surname' => 'Doe',
                'email' => 'john@example.com',
            ],
        ]);
});

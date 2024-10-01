<?php

namespace Tests\Feature\Api\Tasks;

use App\Models\Task;
use App\Models\User;

test('user can see task list', function () {
    $user = User::factory()->create();
    Task::factory(10)->create();

    $response = $this->actingAs($user)->getJson('api/tasks');

    $response->assertStatus(200)
        ->assertJsonCount(10, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'due_date',
                    'status',
                    'creator' => ['id', 'name', 'surname', 'email'],
                ],
            ],
        ]);
});

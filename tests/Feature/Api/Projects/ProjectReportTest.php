<?php

namespace Tests\Feature\Api\Projects;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

test('user can get project report', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create();

    Task::factory(10)->inProgress()->create(['project_id' => $project->id]);
    Task::factory(25)->completed()->create(['project_id' => $project->id]);
    Task::factory(15)->asNew()->create(['project_id' => $project->id]);

    $response = $this->actingAs($user)->getJson('/api/projects/report');

    $response->assertStatus(200)
        ->assertJsonStructure([
            '*' => [
                'title',
                'number_of_tasks',
                'percentage_of_completed_tasks',
            ],
        ])
        ->assertJsonCount(1)
        ->assertJson([
            [
                'title' => $project->title,
                'number_of_tasks' => 50,
                'percentage_of_completed_tasks' => 50.0,
            ],
        ]);
});

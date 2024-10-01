<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;

test('existing user can login', function () {
    $user = User::factory()->create([
        'name' => 'John',
        'surname' => 'Doe',
        'email' => 'john.doe@example.com',
        'password' => 'password',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'john.doe@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'User logged in successfully.',
            'user' => [
                'name' => 'John',
                'surname' => 'Doe',
                'email' => 'john.doe@example.com',
            ],
        ])
        ->assertJsonStructure([
            'message',
            'user' => [
                'name',
                'surname',
                'email',
            ],
            'token',
        ]);
});

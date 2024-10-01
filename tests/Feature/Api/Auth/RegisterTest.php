<?php

namespace Tests\Feature\Api\Auth;

test('new user can register', function () {
    $response = $this->post('/api/register', [
        'name' => 'John',
        'surname' => 'Doe',
        'email' => 'john.doe@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'message' => 'User registered successfully. You can now login.',
        ]);

    $this->assertDatabaseHas('users', [
        'name' => 'John',
        'surname' => 'Doe',
        'email' => 'john.doe@example.com',
    ]);
});

<?php

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->use(RefreshDatabase::class);

it('registers a new user successfully', function () {
    $role = Role::factory()->create();

    $request = [
        'name' => 'john doe',
        'email' => 'johndoe@example.com',
        'password' => 'password123',
        'c_password' => 'password123',
        'role_id' => $role->id,
    ];

    $response = $this->postJson('/api/register', $request);

    $response->assertOk()
        ->assertJson([
            'success' => true,
        ])
        ->assertJsonStructure([
            'data' => ['token', 'name'],
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'johndoe@example.com',
    ]);

});

it('return error when the role doesnt exist', function () {
    $request = [
        'name' => 'john doe',
        'email' => 'johndoe@example.com',
        'password' => 'password123',
        'c_password' => 'password123',
        'role_id' => 14,
    ];

    $response = $this->postJson('/api/register', $request);

    $response->assertNotFound()
        ->assertJson([
            'success' => false,
        ]);

    $this->assertDatabaseMissing('users', [
        'email' => 'johndoe@example.com',
    ]);

});

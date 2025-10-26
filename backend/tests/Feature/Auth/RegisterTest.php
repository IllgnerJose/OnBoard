<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
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

    $user = User::where('email', 'johndoe@example.com')->first();
    expect(Hash::check($request['password'], $user->password))->toBeTrue();
});

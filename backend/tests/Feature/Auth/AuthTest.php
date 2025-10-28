<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
pest()->use(RefreshDatabase::class);

it('logs in an existing user successfully', function () {
    User::factory()->create([
        'email' => 'johndoe@example.com',
        'password' => Hash::make('password123'),
    ]);

    $request = [
        'email' => 'johndoe@example.com',
        'password' => 'password123',
    ];

    $response = $this->postJson('/api/login', $request);

    $response->assertOk()
        ->assertJson([
            'success' => true,
        ])
        ->assertJsonStructure([
            'data' => ['token', 'name'],
        ]);
});

it('fails login with wrong password', function () {
    User::factory()->create([
        'email' => 'johndoe@example.com',
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'johndoe@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertUnauthorized()
        ->assertJson([
            'success' => false,
        ]); 
});

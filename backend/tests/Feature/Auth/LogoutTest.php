<?php

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('user can logout successfully', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/logout');

    $response->assertOk()
        ->assertJson([
            'message' => 'Logout realizado com sucesso.'
        ]);

    $this->assertDatabaseCount('personal_access_tokens', 0);
});

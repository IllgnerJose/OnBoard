<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
pest()->use(RefreshDatabase::class);

it('returns all destinations', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->getJson('/api/destinations');

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);
});

<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
pest()->use(RefreshDatabase::class);

it('returns all statuses', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->getJson('/api/statuses');

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);
});

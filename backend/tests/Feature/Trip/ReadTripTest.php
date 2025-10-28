<?php

use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
pest()->use(RefreshDatabase::class);

it('returns all trips', function () {
    $this->seed();
    $user = User::factory()->create();
    Trip::factory()->count(3)->create();

    $response = $this
        ->actingAs($user)
        ->getJson('/api/trips');

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);
});

it('returns a single trip', function () {
    $this->seed();
    $user = User::factory()->create();
    $trip = Trip::factory()->create();

    $response = $this
        ->actingAs($user)
        ->getJson("/api/trips/{$trip->id}");

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);
});
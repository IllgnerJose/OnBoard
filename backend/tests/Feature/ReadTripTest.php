<?php

use App\Models\Trip;
use App\Models\User; 

it('returns all trips', function () {
    $user = User::factory()->create();
    $trips = Trip::factory()->count(3)->create();

    $response = $this->getJson('/api/trips');

    $response->assertOk()
        ->actingAs($user)
        ->assertJsonCount(3, 'data')
        ->assertJsonFragment(['id' => $trips->first()->id]);
});

it('returns a single trip', function () {
    $user = User::factory()->create();
    $trip = Trip::factory()->create();

    $response = $this->getJson("/api/trips/{$trip->id}");

    $response->assertOk()
        ->actingAs($user)
        ->assertJsonPath('data.id', $trips->id);
});
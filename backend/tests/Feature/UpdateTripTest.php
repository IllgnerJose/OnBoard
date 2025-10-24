<?php 

use App\Models\User;
use App\Models\Trip; 

it("approve the trip if the user is admin", function () {
    $user = User::factory()->admin()->create();
    $trip = Trip::factory()->create();

    $request = [
        "status_id" => Status::where('name', TripStatus::APPROVED)->first()->id,
    ];

    $trip->refresh();

    $response = $this->actingAs($user)
        ->putJson("/trips/" . $trip->id, $request);

    $response->assertRedirect();

    expect($trip->status_id)
        ->toBe($request["status_id"]);
});

it("cancel the trip if the user is an admin", function () {
    $user = User::factory()->admin()->create();
    $trip = Trip::factory()->create();

    $request = [
        "status_id" => Status::where('name', TripStatus::CANCELED)->first()->id,
    ];

    $trip->refresh();

    $response = $this->actingAs($user)
        ->putJson("/trips/" . $trip->id, $request);

    $response->assertRedirect();

    expect($trip->status_id)
        ->toBe($request["status_id"]);
});

it("can't cancel the trip if it is already approved", function () {
    $user = User::factory()->admin()->create();
    $trip = Trip::factory()->create([
        "status_id" => Status::where('name', TripStatus::APPROVED)->first()->id,
    ]);

    $request = [
        "status_id" => Status::where('name', TripStatus::CANCELED)->first()->id,
    ];

    $trip->refresh();

    $response = $this->actingAs($user)
        ->putJson("/trips/" . $trip->id, $request);

    $response->assertUnauthorized();

    expect($trip->status_id)
        ->not()->toBe($request["status_id"]);
});

it("can't update the trip status if is a regular user", function () {
    $user = User::factory()->create();
    $trip = Trip::latest()->first();

    $request = [
        "status_id" => Status::where('name', TripStatus::CANCELED)->first()->id,
    ];

    $trip->refresh();

    $response = $this->actingAs($user)
        ->putJson("/trips/" . $trip->id, $request);

    $response->assertUnauthorized();

    expect($trip->status_id)
        ->not()->toBe($request["status_id"]);
});
<?php 

use App\Models\User;
use App\Models\Status;
use App\Models\Destination;
use App\Enum\TripStatus;

it("creates a trip", function () {
    $this->seed();
    $user = User::factory()->create();
    $destination = Destination::latest()->first();

    $request = [
        "departure_date" => now(),
        "return_date" => now(),
        "destionation_id " => $destination->id,
        "status_id" => Status::where('name', TripStatus::REQUESTED)->first()->id,
        "user_id" => $user->id,
    ];

    $response = $this->actingAs($user)
        ->postJson("/api/trips/", $request);

    $response->assertRedirect();

    $this->assertDatabaseHas('trips', [
        $request,
    ]); 
});


<?php 

use App\Models\User;
use App\Models\Status;
use App\Models\Destination;
use App\Enums\TripStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
pest()->use(RefreshDatabase::class);

it("creates a trip", function () {
    $user = User::factory()->create();
    $destination = Destination::factory()->create();
    $status = Status::factory()->create();

    $request = [
        "departure_date" => now(),
        "return_date" => now(),
        "destination_id" => $destination->id,
        "status_id" => $status->id,
        "user_id" => $user->id,
    ];

    $response = $this
        ->actingAs($user)
        ->postJson("/api/trips/", $request);
    
    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);

    $this->assertDatabaseHas('trips', $request); 
});

it("returns a error when the status doesn't exits", function () {
    $user = User::factory()->create();
    $destination = Destination::factory()->create();

    $request = [
        "departure_date" => now(),
        "return_date" => now(),
        "destination_id" => $destination->id,
        "status_id" => 3,
        "user_id" => $user->id,
    ];

    $response = $this
        ->actingAs($user)
        ->postJson("/api/trips/", $request);
    
    $response
        ->assertNotFound()
        ->assertJson([
            'success' => false,
        ]);

    $this->assertDatabaseMissing('trips', $request); 
});


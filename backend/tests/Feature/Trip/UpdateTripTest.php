<?php 

use App\Models\User;
use App\Models\Trip; 
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
pest()->use(RefreshDatabase::class);

it("approves the trip if the user is admin", function () {
    $user = User::factory()->admin()->create();
    $trip = Trip::factory()->create();
    $status = Status::factory()->approved()->create();

    $response = $this->actingAs($user)
        ->putJson("api/trips/approve/" . $trip->id);

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);
    
    $trip->refresh();

    expect($trip->status_id)
        ->toBe($status->id);
});

it("don't approve the trip if it doesn't exist", function () {
    $user = User::factory()->admin()->create();

    $response = $this->actingAs($user)
        ->putJson("api/trips/approve/" . 2);

    $response
        ->assertNotFound()
        ->assertJson([
            'success' => false,
        ]);
});

it("don't approve the trip if the status doesn't exist", function () {
    $user = User::factory()->admin()->create();
    $trip = Trip::factory()->create();

    $response = $this->actingAs($user)
        ->putJson("api/trips/approve/" . $trip->id);
        
    $response
        ->assertNotFound()
        ->assertJson([
            'success' => false,
        ]);
});

it("don't approve the trip if it is already approved", function () {
    $user = User::factory()->admin()->create();
    $trip = Trip::factory()->approved()->create();

    $response = $this->actingAs($user)
        ->putJson("api/trips/approve/" . $trip->id);

    $response
        ->assertConflict()
        ->assertJson([
            'success' => false,
        ]);
});

it("cancels the trip if the user is an admin", function () {
    $user = User::factory()->admin()->create();
    $trip = Trip::factory()->create();
    $status = Status::factory()->canceled()->create();

    $response = $this->actingAs($user)
        ->putJson("api/trips/cancel/" . $trip->id);

    $trip->refresh();

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);

    expect($trip->status_id)
        ->toBe($status->id);
});

it("don't cancel the trip if it doesn't exist", function () {
    $user = User::factory()->admin()->create();
    $status = Status::factory()->canceled()->create();

    $response = $this->actingAs($user)
        ->putJson("api/trips/cancel/" . 2);

    $response
        ->assertNotFound()
        ->assertJson([
            'success' => false,
        ]);
});

it("don't cancel the trip if the status doesn't exist", function () {
    $user = User::factory()->admin()->create();
    $trip = Trip::factory()->create();

    $response = $this->actingAs($user)
        ->putJson("api/trips/cancel/" . $trip->id);

    $response
        ->assertNotFound()
        ->assertJson([
            'success' => false,
        ]);
});

it("don't cancel the trip if it is already canceled", function () {
    $user = User::factory()->admin()->create();
    $trip = Trip::factory()->canceled()->create();

    $response = $this->actingAs($user)
        ->putJson("api/trips/cancel/" . $trip->id);

    $response
        ->assertConflict()
        ->assertJson([
            'success' => false,
        ]);
});

it("don't cancel the trip if it is already approved", function () {
    $user = User::factory()->admin()->create();
    $status = Status::factory()->canceled()->create();
    $canceledStatus = Status::factory()->canceled()->create();
    $trip = Trip::factory()->approved()->create();

    $response = $this->actingAs($user)
        ->putJson("api/trips/cancel/" . $trip->id);

    $trip->refresh();

    $response
        ->assertConflict()
        ->assertJson([
            'success' => false,
        ]);

    expect($trip->status_id)
        ->not()->toBe($status->id);
});

it("dont't approve the trip status if it is a regular user", function () {
    $user = User::factory()->create();
    $trip = Trip::factory()->create();
    $status = Status::factory()->canceled()->create();

    $response = $this->actingAs($user)
        ->putJson("api/trips/approve/" . $trip->id);

    $trip->refresh();

    $response
        ->assertForbidden()
        ->assertJson([
            'success' => false,
        ]);

    expect($trip->status_id)
        ->not()->toBe($status->id);
});

it("dont't cancel the trip status if it is a regular user", function () {
    $user = User::factory()->create();

    $trip = Trip::factory()->create();
    $status = Status::factory()->canceled()->create();

    $response = $this->actingAs($user)
        ->putJson("api/trips/cancel/" . $trip->id);

    $trip->refresh();

    $response
        ->assertForbidden()
        ->assertJson([
            'success' => false,
        ]);

    expect($trip->status_id)
        ->not()->toBe($status->id);
});
<?php 

use App\Models\User;
use App\Models\Trip; 
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
pest()->use(RefreshDatabase::class);

/**
 * Atualizar o status de um pedido de viagem: Possibilitar a atualização do status para "aprovado".
 */
it("approves the trip if the user is admin", function () {
    $user = User::factory()->admin()->create();
    $trip = Trip::factory()->create();
    $status = Status::factory()->approved()->create();

    $request = [
        "status_id" => $status->id,
    ];

    $response = $this->actingAs($user)
        ->putJson("api/trips/approve/" . $trip->id, $request);

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);
    
    $trip->refresh();

    expect($trip->status_id)
        ->toBe($request["status_id"]);
});

/**
 * Atualizar o status de um pedido de viagem: Possibilitar a atualização do status para "cancelado".
 */
it("cancels the trip if the user is an admin", function () {
    $user = User::factory()->admin()->create();
    $trip = Trip::factory()->create();
    $status = Status::factory()->canceled()->create();

    $request = [
        "status_id" => $status->id,
    ];

    $response = $this->actingAs($user)
        ->putJson("api/trips/cancel/" . $trip->id, $request);

    $trip->refresh();

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);

    expect($trip->status_id)
        ->toBe($request["status_id"]);
});

/**
 * Cancelar pedido de viagem após aprovação: Implementar uma lógica de negócios que só permita o cancelamento do pedido caso ele ainda não tenha sido aprovado
 */
it("can't cancel the trip if it is already approved", function () {
    $user = User::factory()->admin()->create();

    $canceledStatus = Status::factory()->canceled()->create();

    $trip = Trip::factory()->approved()->create();

    $request = [
        "status_id" => $canceledStatus->id,
    ];

    $response = $this->actingAs($user)
        ->putJson("api/trips/cancel/" . $trip->id, $request);

    $trip->refresh();

    $response
        ->assertStatus(409)
        ->assertJson([
            'success' => false,
        ]);

    expect($trip->status_id)
        ->not()->toBe($request["status_id"]);
});

/**
 * Atualizar o status de um pedido de viagem: (nota: o usuário que fez o pedido não pode alterar o status do mesmo, somente um usuário administrador)
 */
it("can't approve the trip status if is a regular user", function () {
    $user = User::factory()->create();

    $trip = Trip::factory()->create();
    $status = Status::factory()->canceled()->create();

    $request = [
        "status_id" => $status->id,
    ];

    $response = $this->actingAs($user)
        ->putJson("api/trips/approve/" . $trip->id, $request);

    $trip->refresh();

    $response
        ->assertStatus(403)
        ->assertJson([
            'success' => false,
        ]);

    expect($trip->status_id)
        ->not()->toBe($request["status_id"]);
});

it("can't cancel the trip status if is a regular user", function () {
    $user = User::factory()->create();

    $trip = Trip::factory()->create();
    $status = Status::factory()->canceled()->create();

    $request = [
        "status_id" => $status->id,
    ];

    $response = $this->actingAs($user)
        ->putJson("api/trips/cancel/" . $trip->id, $request);

    $trip->refresh();

    $response
        ->assertStatus(403)
        ->assertJson([
            'success' => false,
        ]);

    expect($trip->status_id)
        ->not()->toBe($request["status_id"]);
});
<?php 

use App\Models\User;
use App\Models\Status;
use App\Models\Destination;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
pest()->use(RefreshDatabase::class);

/**
 * Criar um pedido de viagem: Um pedido deve incluir o ID do pedido, o nome do solicitante, o destino, a data de ida, a data de volta e o status (solicitado, aprovado, cancelado)
 */
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


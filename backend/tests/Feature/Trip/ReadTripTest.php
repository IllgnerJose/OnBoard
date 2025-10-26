<?php

use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
pest()->use(RefreshDatabase::class);

/**
 * Listar todos os pedidos de viagem: Retornar todos os pedidos de viagem cadastrados, com a opção de filtrar por status, período de tempo (ex: pedidos feitos ou com datas de viagem dentro de uma faixa de datas) e destino.
 */
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

/**
 * Consultar um pedido de viagem: Retornar as informações detalhadas de um pedido de viagem com base no ID fornecido.
 */
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
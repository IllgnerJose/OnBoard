<?php 


use App\Exceptions\AlreadyApprovedTripException;
use App\Enums\TripStatus;
use App\Models\Trip;
use App\Models\Status;
use App\Services\TripService;
use App\Repositories\TripRepository;


use Tests\TestCase;

uses(TestCase::class);

/**
 *Atualizar o status de um pedido de viagem: Possibilitar a atualização do status para "aprovado" ou "cancelado". 
 */
it('updates a trip successfully', function () {
    $requestedStatus = new Status([
        'id' => 1, 
        'name' => TripStatus::REQUESTED,
    ]);

    $approvedStatus = new Status([
        'id' => 2, 
        'name' => TripStatus::APPROVED,
    ]);

    $trip = new Trip([
        'id' => 1,
        'status_id' => $requestedStatus->id,
    ]);

    $trip->setRelation('status', $requestedStatus);

    $validatedData = [
        'status_id' => $approvedStatus->id
    ];
    
    $repositoryMock = Mockery::mock(TripRepository::class);

    $repositoryMock->shouldReceive('update')
        ->once()
        ->with($validatedData, $trip)
        ->andReturn($trip);
    
    $service = new TripService($repositoryMock);
    
    $result = $service->update($validatedData, $trip);
    expect($result)->toBe($trip);
});

/**
 * Cancelar pedido de viagem após aprovação: Implementar uma lógica de negócios que só permita o cancelamento do pedido caso ele ainda não tenha sido aprovado
 */
it('throws exception when try to cancel a trip that is already approved', function () {
    $approvedStatus = new Status([
        'id' => 2, 
        'name' => TripStatus::APPROVED->name,
    ]);

    $canceledStatus = new Status([
        'id' => 3, 
        'name' => TripStatus::CANCELED->name,
    ]);

    $trip = new Trip([
        'id' => 1,
        'status_id' => $approvedStatus->id,
    ]);

    $trip->setRelation('status', $approvedStatus);

    $repositoryMock = Mockery::mock(TripRepository::class);
    
    $repositoryMock->shouldNotReceive('update');
    
    $service = new TripService($repositoryMock);
    
    $validatedData = [
        "status_id" => $canceledStatus->id,
    ];

    $service->update($validatedData, $trip);
})->throws(AlreadyApprovedTripException::class);
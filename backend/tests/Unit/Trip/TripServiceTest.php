<?php 


use App\Exceptions\AlreadyApprovedTripException;
use App\Enums\TripStatus;
use App\Models\Trip;
use App\Models\Status;
use App\Models\User;
use App\Models\Role;
use App\Enums\UserRole;
use App\Services\TripService;
use App\Repositories\TripRepository;
use Illuminate\Database\Eloquent\Collection;

use Tests\TestCase;

uses(TestCase::class);


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

it('returns all trips when user is admin', function () {
    $role = new Role([
        'id' => 2,
        'name' => UserRole::ADMIN->name,
    ]);

    $admin = new User([
        'id' => 1,
        'role_id' => $role->id,
    ]);

    $admin->setRelation('role', $role);

    Auth::shouldReceive('user')
        ->once()
        ->andReturn($admin);

    $expectedTrips = new Collection([
        new Trip(['id' => '1']),
        new Trip(['id' => '2']),
        new Trip(['id' => '3']),
    ]);

    $repositoryMock = Mockery::mock(TripRepository::class);

    $repositoryMock->shouldReceive('all')
        ->once()
        ->andReturn($expectedTrips);

    $repositoryMock->shouldNotReceive('getUserTrips');

    $service = new TripService($repositoryMock);

    $result = $service->index();

    expect($result)->toBe($expectedTrips);
});

it('returns only user trips when user is not admin', function () {
    $role = new Role([
        'id' => 1,
        'name' => UserRole::USER->name,
    ]);

    $user = new User([
        'id' => 1,
        'role_id' => $role->id,
    ]);

    $user->setRelation('role', $role);

    Auth::shouldReceive('user')
        ->once()
        ->andReturn($user);

    $expectedTrips = new Collection([
        new Trip(['id' => '1', 'user_id' => $user->id]),
        new Trip(['id' => '2', 'user_id' => $user->id]),
        new Trip(['id' => '3', 'user_id' => $user->id]),
    ]);

    $repositoryMock = Mockery::mock(TripRepository::class);

    $repositoryMock->shouldReceive('getUserTrips')
        ->once()
        ->andReturn($expectedTrips);

    $repositoryMock->shouldNotReceive('all');

    $service = new TripService($repositoryMock);

    $result = $service->index();

    expect($result)->toBe($expectedTrips);
});
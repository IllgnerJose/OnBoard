<?php

namespace App\Http\Controllers;

use App\Services\TripService;
use App\Services\StatusService;
use App\Http\Requests\StoreTripRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TripResource;
use App\Enums\TripStatus;
use App\Notifications\TripStatusChanged;

class TripController extends Controller
{
    public function __construct(
        protected TripService $tripService,
        protected StatusService $statusService,
    ){}

    public function index(): JsonResponse
    {
        $trips = $this->tripService->index();
        return $this->sendResponse(TripResource::collection($trips), 'Pedidos de viagem retornados com sucesso.');
    }

    public function store(StoreTripRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $status = $this->statusService->getByName(TripStatus::REQUESTED->name);

        if (is_null($status)) {
            return $this->sendError("Status " . TripStatus::REQUESTED->name . " não encontrado.");
        }

        $validatedData["status_id"] = $status->id;

        $trip = $this->tripService->store($validatedData);
        return $this->sendResponse(new TripResource($trip), 'Pedido de viagem criado com sucesso.');
    }

    public function show(int $id): JsonResponse
    {
        $trip = $this->tripService->show($id);

        if (is_null($trip)) {
            $this->sendError('Pedido de viagem não encontrado.');
        }

        return $this->sendResponse(new TripResource($trip), 'Pedido de viagem retornado com sucesso.');
    }

    private function updateTripStatus(int $id, TripStatus $status, string $successMessage): JsonResponse
    {
        $trip = $this->tripService->show($id);

        if (is_null($trip)) {
            return $this->sendError('Pedido de viagem não encontrado.');
        }

        if (Auth::user()->cannot('updateStatus', $trip)) {
            return $this->sendError('O usuário não tem permissão para atualizar o status do pedido.', [], 403);
        }

        $statusModel = $this->statusService->getByName($status->name);

        if (is_null($statusModel)) {
            return $this->sendError("Status '{$status->name}' não encontrado.");
        }

        $validatedData = ['status_id' => $statusModel->id];

        $trip = $this->tripService->update($validatedData, $trip);
        
        $trip->user->notify(new TripStatusChanged($trip, $statusModel->name));

        return $this->sendResponse(new TripResource($trip), $successMessage);
    }

    public function approve(int $id): JsonResponse
    {
        return $this->updateTripStatus($id, TripStatus::APPROVED, 'Pedido de viagem aprovado com sucesso.');
    }

    public function cancel(int $id): JsonResponse
    {
        return $this->updateTripStatus($id, TripStatus::CANCELED, 'Pedido de viagem cancelado com sucesso.');
    }
}

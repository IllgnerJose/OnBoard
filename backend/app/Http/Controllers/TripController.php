<?php

namespace App\Http\Controllers;

use App\Services\TripService;
use App\Http\Requests\StoreTripRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TripResource;
use App\Models\Status;
use App\Enums\TripStatus;
use App\Notifications\TripStatusChanged;

class TripController extends Controller
{
    public function __construct(
        protected TripService $tripService,
    ){}

    public function index(): JsonResponse
    {
        $trips = $this->tripService->index();
        return $this->sendResponse(TripResource::collection($trips), 'Pedidos de viagem retornados com sucesso.');
    }

    public function store(StoreTripRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $status = Status::where('name', TripStatus::REQUESTED->name)->first();
        $validatedData["status_id"] = $status ? $status->id : null;

        $trip = $this->tripService->store($validatedData);
        return $this->sendResponse(new TripResource($trip), 'Pedido de viagem criado com sucesso.');
    }

    public function show(int $id): JsonResponse
    {
        $trip = $this->tripService->show($id);

        if (is_null($trip)) {
            $this->sendError('Produto não encontrado.');
        }

        return $this->sendResponse(new TripResource($trip), 'Pedido de viagem retornado com sucesso.');
    }

    private function updateTripStatus(int $id, string $statusName, string $successMessage): JsonResponse
    {
        $trip = $this->tripService->show($id);

        if (is_null($trip)) {
            return $this->sendError('Produto não encontrado.');
        }

        if (Auth::user()->cannot('updateStatus', $trip)) {
            return $this->sendError('O usuário não tem permissão para atualizar o status do pedido.', [], 403);
        }

        $status = Status::where('name', $statusName)->first();
        $validatedData = ['status_id' => $status?->id];

        $trip = $this->tripService->update($validatedData, $trip);

        $trip->user->notify(new TripStatusChanged($trip, $statusName));

        return $this->sendResponse(new TripResource($trip), $successMessage);
    }

    public function approve(int $id): JsonResponse
    {
        return $this->updateTripStatus($id, TripStatus::APPROVED->name, 'Pedido de viagem aprovado com sucesso.');
    }

    public function cancel(int $id): JsonResponse
    {
        return $this->updateTripStatus($id, TripStatus::CANCELED->name, 'Pedido de viagem cancelado com sucesso.');
    }
}

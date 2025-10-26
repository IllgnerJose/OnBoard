<?php

namespace App\Http\Controllers;

use App\Services\TripService;
use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TripResource;
use Illuminate\Support\Facades\Gate;

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
        $trip = $this->tripService->store($request->validated());
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

    public function update(UpdateTripRequest $request, int $id): JsonResponse
    {
        $trip = $this->tripService->show($id);

        if (is_null($trip)) {
            $this->sendError('Produto não encontrado.');

        } else if ($request->user()->cannot('updateStatus', $trip)) {
            return $this->sendError('O usuario não tem permissao para atualizar o status do pedido.', [] , 401);

        }

        $trip = $this->tripService->update($request->validated(), $trip);

        return $this->sendResponse(new TripResource($trip), 'Pedido de viagem atualizado com sucesso.');
    }
}

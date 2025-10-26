<?php

namespace App\Http\Controllers;
use App\Http\Resources\DestinationResource;
use Illuminate\Http\JsonResponse;
use App\Services\DestinationService;

class DestinationController extends Controller
{
    public function __construct(
        protected DestinationService $destinationService,
    ){}
    
    public function index(): JsonResponse
    {
        $destionations = $this->destinationService->index();
        return $this->sendResponse(DestinationResource::collection($destionations), 'Destinos retornados com sucesso.');
    }
}

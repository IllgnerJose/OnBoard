<?php

namespace App\Http\Controllers;
use App\Http\Resources\StatusResource;
use Illuminate\Http\JsonResponse;
use App\Services\StatusService;

class StatusController extends Controller
{
    public function __construct(
        protected StatusService $statusService,
    ){}

    public function index(): JsonResponse
    {
        $status = $this->statusService->index();
        return $this->sendResponse(StatusResource::collection($status), 'Status retornados com sucesso.');
    }
}


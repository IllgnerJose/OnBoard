<?php

namespace App\Exceptions;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Exception;

class AlreadyApprovedTripException extends Exception
{
    use ResponseTrait;

    public function render($request): JsonResponse
    {
        return $this->sendError('Não é possível cancelar um pedido já aprovado.', [], Response::HTTP_CONFLICT);
    }
}

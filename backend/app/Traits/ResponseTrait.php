<?php 

namespace App\Traits;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait 
{
    protected function sendResponse($result, $message) 
    {
        $response = [
            "success" => true,
            "data" => $result,
            "message" => $message,
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    protected function sendError($error, $errorMessages = [], $code = Response::HTTP_NOT_FOUND)
    {
        $response = [
            "success" => false,
            "message" => $error,
        ];

        if(!empty($errorMessages)) {
            $response["data"] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
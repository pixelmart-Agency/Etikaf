<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;

class ErrorResponse
{
    public static function send($message = 'Request failed', $statusCode = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }
}

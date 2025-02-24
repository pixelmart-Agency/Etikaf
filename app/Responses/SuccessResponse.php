<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;

class SuccessResponse
{
    public static function send($data = null, $message = 'Request successful', $statusCode = 200, $isPagination = false)
    {
        if ($isPagination) {
            $pagination = [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
            ];
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data,
                'pagination' => $pagination,
            ], $statusCode);
        }
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}

<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function successResponse($data = null, $message = 'Success', $code = 200, $extra = [])
    {
        return response()->json(array_merge([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $extra), $code);
    }

    protected function errorResponse($message = 'Error', $code = 400, $data = null)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
} 
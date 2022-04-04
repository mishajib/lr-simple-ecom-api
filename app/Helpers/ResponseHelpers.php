<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('success_response')) {
    function success_response($message, $status_code, $data = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $status_code);
    }
}

if (!function_exists('error_response')) {
    function error_response($message, $status_code, $data = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => $data,
        ], $status_code);
    }
}

if (!function_exists('index_response')) {
    function index_response($message, $status_code, $payload = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'payload' => $payload,
        ], $status_code);
    }
}


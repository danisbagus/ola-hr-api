<?php

namespace App\Helpers;

class ApiResponse
{
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_INTERNAL_ERROR = 500;


    public static function success($data = null, $message = 'Success', $statusCode = self::HTTP_OK)
    {
        return response()->json([
            'code' => 'SUCCESS',
            'message' => $message,
            'errors' => null,
            'server_time' => now()->timestamp,
            'data' => $data,
        ], status: $statusCode);
    }

    public static function badRequest($message = 'Bad Request', $errors = null)
    {
        return response()->json([
            'code' => 'BAD_REQUEST',
            'message' => $message,
            'errors' => $errors,
            'server_time' => now()->timestamp,
            'data' => null,
        ], status: self::HTTP_BAD_REQUEST);
    }

    public static function internalServerError($errors = null, $message = 'Internal Server Error')
    {
        return response()->json([
            'code' => 'INTERNAL_SERVER_ERROR',
            'message' => $message,
            'errors' => $errors->getMessage(),
            'server_time' => now()->timestamp,
            'data' => null,
        ], status: self::HTTP_INTERNAL_ERROR);
    }

    // unauthorized
    public static function unauthorized($message = 'Unauthorized', $erorrs = null)
    {
        return response()->json([
            'code' => 'UNAUTHORIZED',
            'message' => $message,
            'errors' => $erorrs,
            'server_time' => now()->timestamp,
            'data' => null,
        ], status: self::HTTP_UNAUTHORIZED);
    }

    public static function notFound($message = 'Not Found')
    {
        return response()->json([
            'code' => 'NOT_FOUND',
            'message' => $message,
            'errors' => null,
            'server_time' => now()->timestamp,
            'data' => null,
        ], status: self::HTTP_NOT_FOUND);
    }
}

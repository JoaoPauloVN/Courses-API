<?php
namespace App\Trait;

use Illuminate\Http\JsonResponse;

Trait HttpResponses
{
    protected function response(string $message = null,  $data = [], int $code = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function success($data = [], int $code = 200): JsonResponse
    {
        return $this->response('success', $data, $code);
    }

    protected function error(array $data = [], int $code = 200): JsonResponse
    {
        return $this->response('error', $data, $code);
    }
}
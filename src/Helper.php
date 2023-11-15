<?php

use Symfony\Component\HttpFoundation\JsonResponse;

if(!function_exists('custom_response')){
    function custom_response(string $message = '', mixed $data = [], int $status = 200):JsonResponse
    {
        return new JsonResponse([
            'message' => $message,
            'data' => $data
        ],$status);
    }
}
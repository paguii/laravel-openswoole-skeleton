<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class NotFoundException extends Exception
{
    public function __construct($message = "Not Found", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function report() {}

    public function render($request): JsonResponse
    {
        return response()->json(['error' => $this->getMessage()], 404);
    }
}

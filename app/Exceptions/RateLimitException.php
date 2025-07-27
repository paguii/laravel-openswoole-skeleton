<?php

namespace App\Exceptions;

use Exception;

class RateLimitException extends Exception
{
    public function __construct($message = "Rate limit violation", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function report() {}

    public function render($request)
    {
        return response()->json(['error' => $this->getMessage()], 429);
    }
}

<?php

namespace App\Exceptions;

use Exception;

class BusinessRuleException extends Exception
{
    public function __construct($message = "Business rule violation", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function report() {}

    public function render($request)
    {
        return response()->json(['error' => $this->getMessage()], 400);
    }
}

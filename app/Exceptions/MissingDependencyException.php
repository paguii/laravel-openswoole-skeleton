<?php

namespace App\Exceptions;

use App\Presentation\Http\Response\ApiResponse;
use App\Utils\HttpStatus;
use Exception;
use Illuminate\Http\JsonResponse;

class MissingDependencyException extends Exception
{
    private array $errors = [];

    public function __construct($message = "Invalid parameter", $code = 0, array $errors = [], Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function report() {}

    public function render(): JsonResponse
    {
        $response = new ApiResponse();

        $response->setSuccess(false);
        $response->setStatusCode(HttpStatus::FAILED_DEPENDENCY);
        $response->setError($this->errors);
        $response->setMessage($this->getMessage());

        return response()->json($response->toArray(), $response->getStatusCode());
    }
}

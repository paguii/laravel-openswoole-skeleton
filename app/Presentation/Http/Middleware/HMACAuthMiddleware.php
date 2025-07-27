<?php

namespace App\Presentation\Http\Middleware;

use Closure;
use App\Presentation\Http\Response\ApiResponse;
use App\Utils\HttpStatus;
use Illuminate\Http\Request;

class HMACAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $hmacSignature = $request->header('X-HMAC-Signature');
        $payload = $request->getContent();
        $secret = env('HMAC_SECRET');

        $computedSignature = hash_hmac('sha256', $payload, $secret);

        if (hash_equals($computedSignature, $hmacSignature)) {
            return $next($request);
        }

        $response = new ApiResponse();

        $response->setSuccess(false);
        $response->setStatusCode(HttpStatus::UNAUTHORIZED);
        $response->setMessage('Unauthorized');

        return response()->json($response->toArray(), $response->getStatusCode());
    }
}

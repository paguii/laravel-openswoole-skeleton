<?php

// app/Http/Middleware/BearerAuthMiddleware.php
namespace App\Http\Middleware;

use Closure;
use App\Presentation\Http\Response\ApiResponse;
use App\Utils\HttpStatus;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class BearerAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $secret = env('JWT_SECRET');
        $algorithm = ['HS256'];
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response('Unauthorized', 401);
        }

        $token = substr($authHeader, 7);

        try {
            $decoded = JWT::decode($token, $secret, $algorithm);
            $request->attributes->set('jwt_user', $decoded);
        } catch (\Exception $e) {
            $response = new ApiResponse();

            $response->setSuccess(false);
            $response->setStatusCode(HttpStatus::UNAUTHORIZED);
            $response->setMessage('Invalid token');

            return response()->json($response->toArray(), $response->getStatusCode());
        }

        return $next($request);
    }
}

<?php

namespace App\Presentation\Http\Middleware;

use Closure;
use App\Application\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!AuthService::isAuthenticated()) {
            return redirect('/');
        }

        return $next($request);
    }
}

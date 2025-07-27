<?php

namespace App\Presentation\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BasicAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        return Auth::onceBasic() ?: $next($request);
    }
}
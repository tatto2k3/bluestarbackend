<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticatePersonal
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->position === 'khách hàng') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}

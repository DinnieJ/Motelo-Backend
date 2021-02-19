<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class AssignGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == JWTAuth::getPayload()->get('role')) {
            return $next($request);
        }

        return response()->json([
            'message' => 'You are unauthorized to make this request'
        ], 403);
    }
}

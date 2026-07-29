<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogSessionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, \Closure $next)
    {
        $sessionId = $request->session()->getId();
        $userId = optional($request->user())->id;

        Log::info("Session ID: {$sessionId}, Authenticated User ID: {$userId}");

        return $next($request);
    }
}

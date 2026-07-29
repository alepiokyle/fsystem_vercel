<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if logged-in user is admin using the admin guard
        $user = Auth::guard('admin')->user();
        if (Auth::guard('admin')->check() && $user && (int) $user->user_role_id === 4) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Unauthorized role for admin guard.');
    }
}

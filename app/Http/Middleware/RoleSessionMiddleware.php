<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DeanAccount;
use App\Models\TeacherAccount;

class RoleSessionMiddleware
{
    /**
     * Handle an incoming request.
     * This middleware checks the session for active_role and sets the appropriate guard.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated with any guard
        $guards = ['admin', 'dean', 'teacher', 'parent'];
        $authenticatedGuard = null;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $authenticatedGuard = $guard;
                break;
            }
        }

        if (!$authenticatedGuard) {
            return $next($request);
        }

        // Get the active role from session, default to the authenticated guard
        $activeRole = session('active_role', $authenticatedGuard);

        // If active role is different from authenticated guard, we need to switch
        if ($activeRole !== $authenticatedGuard) {
            // For now, we'll keep the authenticated user but change the session role
            // The controller will handle the actual switching
            session(['active_role' => $activeRole]);
        }

        return $next($request);
    }
}

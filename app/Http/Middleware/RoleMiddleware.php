<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage in routes: ->middleware('role:Admin,Dean')
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check user's role directly from the role_name column
        $userRoleName = $user->role_name;

        if (! $userRoleName) {
            Auth::logout();
            abort(403, 'Unauthorized - no role assigned.');
        }

        // case-insensitive compare
        $userRoleLower = strtolower($userRoleName);
        $allowed = array_map('strtolower', $roles);

        if (! in_array($userRoleLower, $allowed)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}

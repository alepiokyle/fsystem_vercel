<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherAccount;

class loginController extends Controller
{
    public function create()
    {
        // Check if any guard is authenticated and redirect to appropriate dashboard
        if (Auth::guard('web')->check()) {
            return redirect()->route('student.studentdashboard');
        }
        if (Auth::guard('parent')->check()) {
            return redirect()->route('parent.parentdashboard');
        }
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::guard('dean')->check()) {
            return redirect()->route('Dean.deandashboard');
        }
        if (Auth::guard('teacher')->check()) {
            return redirect()->route('teacher.teacherdashboard');
        }

        return view('userAuth.login');
    }

    public function store(Request $request)
    {
        // Logout any existing authenticated guards to prevent multiple accounts logged in
        if (Auth::guard('web')->check() || Auth::guard('parent')->check() || Auth::guard('admin')->check() || Auth::guard('dean')->check() || Auth::guard('teacher')->check()) {
            Auth::guard('web')->logout();
            Auth::guard('parent')->logout();
            Auth::guard('admin')->logout();
            Auth::guard('dean')->logout();
            Auth::guard('teacher')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // 1) Try USERS (web guard)
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();

            // Check is_active
            if (!isset($user->is_active) || (int) $user->is_active !== 1) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('suspended');
            }

            // // Unexpected role on web guard
            // Auth::guard('web')->logout();
            // return back()->withErrors(['login_error' => 'Unauthorized role for web guard.'])->withInput();

            // optional: role check
            if ((int) $user->user_role_id !== 7) {
                Auth::guard('web')->logout();
                return back()->withErrors(['login_error' => 'Unauthorized role for web guard.'])->withInput();
            }

            return redirect()->route('student.studentdashboard')->with('success', 'Logged In Successfully');
        }

        // 2) If not user, TRY PARENT (parent guard)
        if (Auth::guard('parent')->attempt($credentials)) {
            $request->session()->regenerate();
            $parent = Auth::guard('parent')->user();

            // Check is_active
            if (!isset($parent->is_active) || (int) $parent->is_active !== 1) {
                Auth::guard('parent')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('suspended');
            }

            // optional: role check
            if ((int) $parent->user_role_id !== 8) {
                Auth::guard('parent')->logout();
                return back()->withErrors(['login_error' => 'Unauthorized role for parent guard.'])->withInput();
            }

            return redirect()->route('parent.parentdashboard')->with('success', 'Logged In Successfully');
        }

        // 3) If not user, TRY admin (admin guard)
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            $admin = Auth::guard('admin')->user();

            // Check is_active
            if (!isset($admin->is_active) || (int)  $admin->is_active !== 1) {
                Auth::guard('admin')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('suspended');
            }

            // optional: role check - removed to allow login, middleware will handle role validation

            return redirect()->route('admin.dashboard')->with('success', 'Logged In Successfully');
        }

        // 4) If not user, TRY dean (dean guard)
        if (Auth::guard('dean')->attempt($credentials)) {
            $request->session()->regenerate();
            $dean = Auth::guard('dean')->user();

            // Check is_active
            if (!isset($dean->is_active) || (int)  $dean->is_active !== 1) {
                Auth::guard('dean')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('suspended');
            }

            // optional: role check
            if ((int)  $dean->user_role_id !== 5) {
                Auth::guard('dean')->logout();
                return back()->withErrors(['login_error' => 'Unauthorized role for dean guard.'])->withInput();
            }

            return redirect()->route('Dean.deandashboard')->with('success', 'Logged In Successfully');
        }

        // 4) If not user, TRY teacher (dean teacher)
        if (Auth::guard('teacher')->attempt($credentials)) {
            $request->session()->regenerate();
            $teacher = Auth::guard('teacher')->user();

            // Check is_active
            if (!isset($teacher->is_active) || (int)  $teacher->is_active !== 1) {
                Auth::guard('teacher')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('suspended');
            }

            // optional: role check
            if ((int)  $teacher->user_role_id !== 6) {
                Auth::guard('teacher')->logout();
                return back()->withErrors(['login_error' => 'Unauthorized role for teacher guard.'])->withInput();
            }

            // Update last login timestamp
            $teacher->update(['last_login_at' => now()]);

            return redirect()->route('teacher.teacherdashboard')->with('success', 'Logged In Successfully');
        }

        // Both failed
        return back()->withErrors(['login_error' => 'Invalid username or password'])->withInput();
    }

    public function logout(Request $request)
    {
        // log out whichever guard is authenticated
        if (Auth::guard('parent')->check()) {
            Auth::guard('parent')->logout();
        }

        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        if (Auth::guard('dean')->check()) {
            Auth::guard('dean')->logout();
        }

        if (Auth::guard('teacher')->check()) {
            Auth::guard('teacher')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully');
    }
}

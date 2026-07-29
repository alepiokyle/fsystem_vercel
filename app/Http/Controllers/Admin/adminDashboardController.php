<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\TeacherAccount;
use Illuminate\Support\Facades\DB;

class adminDashboardController extends Controller
{
    public function index()
    {
        // Count total registered students (user_role_id = 7)
        $totalStudents = User::where('user_role_id', 7)->count();

        // Count total registered teachers (user_role_id = 6)
        $totalTeachers = User::where('user_role_id', 6)->count();

        // Count active teachers (logged in within last 30 days)
        $activeTeachers = TeacherAccount::where('last_login_at', '>=', now()->subDays(30))->count();

        // Count total subjects
        $totalSubjects = Subject::count();

        // Count total system users
        $totalUsers = User::count();

        return view('admin.admindashboard', compact('totalStudents', 'totalTeachers', 'activeTeachers', 'totalSubjects', 'totalUsers'));
    }
}

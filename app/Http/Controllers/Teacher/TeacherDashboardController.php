<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::guard('teacher')->id();
        $assignedSubjects = Subject::where('teacher_id', $teacherId)->withCount('students')->get();

        $subjectsCount = $assignedSubjects->count();
        $studentsCount = $assignedSubjects->sum('students_count');

        return view('teacher.teacherdashboard', compact('subjectsCount', 'studentsCount'));
    }
}

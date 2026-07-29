<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        // Get the authenticated student
        $student = Auth::user();

        // Fetch enrolled subjects for the student
        $enrolledSubjects = $student->subjects()->with('teacher')->get();

        return view('student.Enrolled.Subject', compact('enrolledSubjects'));
    }
}

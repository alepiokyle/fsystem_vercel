<?php

namespace App\Http\Controllers\dean;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherAccount;
use App\Models\Subject;
use App\Models\SchoolYear;

class AssignController extends Controller
{
    public function index()
    {
        $isTeacher = Auth::guard('teacher')->check();
        $isDean = Auth::guard('dean')->check();

        if ($isDean) {
            // Get the authenticated dean
            $user = Auth::guard('dean')->user();
            $departmentName = $user->profile->department->name;
            $departmentId = $user->profile->department_id;
        } elseif ($isTeacher) {
            // Get the authenticated teacher
            $user = Auth::guard('teacher')->user();
            $departmentName = $user->profile->department->name;
            $departmentId = $user->profile->department_id;
        } else {
            abort(403);
        }

        // Fetch active teachers created by admin
        $teachers = TeacherAccount::with('profile', 'creator')->where('is_active', true)->whereNotNull('created_by')->get();

        // Fetch subjects filtered by the department
        $subjects = Subject::with('teacher')->whereHas('department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        })->get();

        // Get unique year levels and sections for the department
        $yearLevels = Subject::whereHas('department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        })->distinct()->pluck('year_level')->filter()->sort();
        $sections = Subject::whereHas('department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        })->distinct()->pluck('section')->filter()->sort();

        return view('dean.AssignTeacher.assign', array_merge(compact('teachers', 'subjects', 'departmentName', 'yearLevels', 'sections', 'isTeacher', 'isDean', 'user'), ['currentUserId' => $user->id]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers_account,id',
        ]);

        $subject = Subject::find($request->subject_id);
        $subject->teacher_id = $request->teacher_id;
        $subject->save();

        return response()->json([
            'success' => true,
            'message' => 'Teacher assigned successfully.'
        ]);
    }

    /**
     * Delete a subject from the database
     */
    public function destroy($id)
    {
        try {
            $subject = Subject::findOrFail($id);

            // Store subject info for success message
            $subjectName = $subject->subject_name;
            $subjectCode = $subject->subject_code;

            // Delete the subject
            $subject->delete();

            return response()->json([
                'success' => true,
                'message' => "Subject '{$subjectCode} - {$subjectName}' has been successfully deleted."
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete subject. Please try again.'
            ], 500);
        }
    }

    /**
     * Check the number of subjects assigned to a teacher in the current school year
     */
    public function checkAssignments($teacher_id)
    {
        $currentSchoolYear = SchoolYear::latest()->first()->schoolyear ?? '2024-2025';

        $count = Subject::where('teacher_id', $teacher_id)
            ->where('school_year', $currentSchoolYear)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Get the creator admin name for a teacher
     */
    public function getCreator($teacher_id)
    {
        $teacher = TeacherAccount::with('creator')->findOrFail($teacher_id);

        $creatorName = $teacher->creator ? $teacher->creator->name : 'Unknown';

        return response()->json(['creator_name' => $creatorName]);
    }
}

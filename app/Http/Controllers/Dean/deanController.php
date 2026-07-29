<?php

namespace App\Http\Controllers\dean;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\DeanProfile;
use App\Models\Department;
use App\Models\TeacherAccount;
use App\Models\SchoolYear;

class DeanController extends Controller
{
    public function index()
    {
        $deanId = Auth::guard('dean')->id();
        $deanAccount = \DB::table('deans_account')->where('id', $deanId)->first();
        $deanProfileId = $deanAccount ? $deanAccount->deans_profile_id : null;
        $deanProfile = DeanProfile::find($deanProfileId);
        $departmentName = $deanProfile ? $deanProfile->department->name : null;

        // Fetch teachers, subjects, school years
        $teachers = TeacherAccount::with('profile')->whereHas('profile.department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        })->get();
        $subjects = Subject::whereHas('department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        })->get();
        $schoolYears = SchoolYear::all();

        return view('Dean.ApproveGrades.Approve', compact('subjects', 'teachers', 'schoolYears'));
    }

    public function fetchGrades(Request $request)
    {
        $deanId = Auth::guard('dean')->id();
        $deanAccount = \DB::table('deans_account')->where('id', $deanId)->first();
        $deanProfileId = $deanAccount ? $deanAccount->deans_profile_id : null;
        $deanProfile = DeanProfile::find($deanProfileId);
        $departmentName = $deanProfile ? $deanProfile->department->name : null;

        $schoolYear = $request->input('school_year');
        $semester = $request->input('semester');
        $subjectId = $request->input('subject_id');
        $teacherId = $request->input('teacher_id');
        $status = $request->input('status');

        $baseQuery = Grade::with(['student', 'subject', 'teacher']);

        if ($schoolYear) {
            $baseQuery->where('school_year', $schoolYear);
        }
        if ($semester) {
            $baseQuery->where('semester', $semester);
        }
        if ($subjectId) {
            $baseQuery->where('subject_id', $subjectId);
        } else if ($departmentName) {
            // If no subject selected, filter by department
            $baseQuery->whereHas('subject.department', function($q) use ($departmentName) {
                $q->where('name', $departmentName);
            });
        }
        if ($teacherId) {
            $baseQuery->where('teacher_id', $teacherId);
        }

        $pendingGrades = collect();
        $approvedGrades = collect();
        $rejectedGrades = collect();

        if (!$status || $status === 'Pending') {
            $pendingQuery = clone $baseQuery;
            $pendingGrades = $pendingQuery->where('status', 'submitted')->get();
        }
        if (!$status || $status === 'Approved') {
            $approvedQuery = clone $baseQuery;
            $approvedGrades = $approvedQuery->where('status', 'approved')->get();
        }
        if (!$status || $status === 'Rejected') {
            $rejectedQuery = clone $baseQuery;
            $rejectedGrades = $rejectedQuery->where('status', 'rejected')->get();
        }

        $mapGrade = function ($grade) {
            return [
                'id' => $grade->id,
                'student_id' => $grade->student_id,
                'student_name' => $grade->student->name,
                'teacher_name' => $grade->teacher->name,
                'prelim' => $grade->prelim,
                'midterm' => $grade->midterm,
                'semi_final' => $grade->semi_final,
                'final' => $grade->final,
                'term_grade' => $grade->term_grade,
                'remarks' => $grade->remarks,
                'status' => ucfirst($grade->status),
            ];
        };

        $result = [
            'pending' => $pendingGrades->map($mapGrade),
            'approved' => $approvedGrades->map($mapGrade),
            'rejected' => $rejectedGrades->map($mapGrade),
        ];

        return response()->json($result);
    }

    public function approveGrade(Request $request)
    {
        $gradeId = $request->input('grade_id');

        $grade = Grade::find($gradeId);
        if (!$grade) {
            return response()->json(['error' => 'Grade not found'], 404);
        }

        $grade->status = 'approved';
        $grade->save();

        return response()->json(['success' => true, 'message' => 'Grade approved']);
    }

    public function rejectGrade(Request $request)
    {
        $gradeId = $request->input('grade_id');

        $grade = Grade::find($gradeId);
        if (!$grade) {
            return response()->json(['error' => 'Grade not found'], 404);
        }

        $grade->status = 'rejected';
        $grade->save();

        return response()->json(['success' => true, 'message' => 'Grade rejected']);
    }
}

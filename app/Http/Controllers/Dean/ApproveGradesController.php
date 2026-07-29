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
use Illuminate\Support\Facades\Validator;

class ApproveGradesController extends Controller
{
    public function index()
    {
        $deanId = Auth::guard('dean')->id();
        $deanAccount = \DB::table('deans_account')->where('id', $deanId)->first();
        $deanProfileId = $deanAccount ? $deanAccount->deans_profile_id : null;
        $deanProfile = DeanProfile::find($deanProfileId);
        $departmentName = $deanProfile ? $deanProfile->department->name : null;

        // Fetch teachers with submitted grades
        $teachers = TeacherAccount::with('profile')->whereHas('profile.department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        })->whereHas('grades', function($q) {
            $q->where('status', 'submitted');
        })->get();

        // Fetch subjects in department
        $subjects = Subject::whereHas('department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        })->get();

        // Fetch school years
        $schoolYears = SchoolYear::orderBy('schoolyear', 'desc')->get();

        return view('Dean.ApproveGrades.Approve', compact('subjects', 'teachers', 'schoolYears'));
    }

    public function getSubjectsByTeacher($teacherId)
    {
        $deanId = Auth::guard('dean')->id();
        $deanAccount = \DB::table('deans_account')->where('id', $deanId)->first();
        $deanProfileId = $deanAccount ? $deanAccount->deans_profile_id : null;
        $deanProfile = DeanProfile::find($deanProfileId);
        $departmentName = $deanProfile ? $deanProfile->department->name : null;

        // Validate teacher belongs to dean's department
        $teacher = TeacherAccount::where('id', $teacherId)->whereHas('profile.department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        })->first();

        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found or not in your department'], 404);
        }

        $subjects = Subject::where('teacher_id', $teacherId)->whereHas('department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        })->get(['id', 'subject_code', 'subject_name']);

        return response()->json($subjects);
    }

    public function fetchGrades(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school_year' => 'nullable|string',
            'semester' => 'nullable|string',
            'subject_id' => 'nullable|integer',
            'teacher_id' => 'nullable|integer',
            'status' => 'nullable|in:Pending,Approved,Rejected,All',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 422);
        }

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

        $baseQuery = Grade::with(['student', 'subject', 'teacher'])->whereHas('subject.department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        });

        if ($schoolYear) {
            $baseQuery->where('school_year', $schoolYear);
        }
        if ($semester) {
            $baseQuery->where('semester', $semester);
        }
        if ($subjectId) {
            $baseQuery->where('subject_id', $subjectId);
        }
        if ($teacherId) {
            $baseQuery->where('teacher_id', $teacherId);
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

        $result = [];

        if (!$status || $status === 'All') {
            $pendingGrades = clone $baseQuery;
            $pendingGrades = $pendingGrades->where('status', 'submitted')->get();

            $approvedGrades = clone $baseQuery;
            $approvedGrades = $approvedGrades->where('status', 'approved')->get();

            $rejectedGrades = clone $baseQuery;
            $rejectedGrades = $rejectedGrades->where('status', 'rejected')->get();

            $result = [
                'pending' => $pendingGrades->map($mapGrade),
                'approved' => $approvedGrades->map($mapGrade),
                'rejected' => $rejectedGrades->map($mapGrade),
            ];
        } elseif ($status === 'Pending') {
            $pendingGrades = clone $baseQuery;
            $pendingGrades = $pendingGrades->where('status', 'submitted')->get();
            $result = [
                'pending' => $pendingGrades->map($mapGrade),
                'approved' => collect(),
                'rejected' => collect(),
            ];
        } elseif ($status === 'Approved') {
            $approvedGrades = clone $baseQuery;
            $approvedGrades = $approvedGrades->where('status', 'approved')->get();
            $result = [
                'pending' => collect(),
                'approved' => $approvedGrades->map($mapGrade),
                'rejected' => collect(),
            ];
        } elseif ($status === 'Rejected') {
            $rejectedGrades = clone $baseQuery;
            $rejectedGrades = $rejectedGrades->where('status', 'rejected')->get();
            $result = [
                'pending' => collect(),
                'approved' => collect(),
                'rejected' => $rejectedGrades->map($mapGrade),
            ];
        }

        return response()->json($result);
    }

    public function approveGrade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grade_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid grade ID'], 422);
        }

        $gradeId = $request->input('grade_id');

        $deanId = Auth::guard('dean')->id();
        $deanAccount = \DB::table('deans_account')->where('id', $deanId)->first();
        $deanProfileId = $deanAccount ? $deanAccount->deans_profile_id : null;
        $deanProfile = DeanProfile::find($deanProfileId);
        $departmentName = $deanProfile ? $deanProfile->department->name : null;

        $grade = Grade::where('id', $gradeId)->whereHas('subject.department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        })->where('status', 'submitted')->first();

        if (!$grade) {
            return response()->json(['error' => 'Grade not found or not eligible for approval'], 404);
        }

        $grade->status = 'approved';
        $grade->save();

        return response()->json(['success' => true, 'message' => 'Grade approved successfully']);
    }

    public function rejectGrade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grade_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid grade ID'], 422);
        }

        $gradeId = $request->input('grade_id');

        $deanId = Auth::guard('dean')->id();
        $deanAccount = \DB::table('deans_account')->where('id', $deanId)->first();
        $deanProfileId = $deanAccount ? $deanAccount->deans_profile_id : null;
        $deanProfile = DeanProfile::find($deanProfileId);
        $departmentName = $deanProfile ? $deanProfile->department->name : null;

        $grade = Grade::where('id', $gradeId)->whereHas('subject.department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        })->where('status', 'submitted')->first();

        if (!$grade) {
            return response()->json(['error' => 'Grade not found or not eligible for rejection'], 404);
        }

        $grade->status = 'rejected';
        $grade->save();

        return response()->json(['success' => true, 'message' => 'Grade rejected successfully']);
    }
}

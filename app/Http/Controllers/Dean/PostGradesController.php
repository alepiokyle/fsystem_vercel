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

class PostGradesController extends Controller
{
    public function index()
    {
        $deanId = Auth::guard('dean')->id();
        $deanAccount = \DB::table('deans_account')->where('id', $deanId)->first();
        $deanProfileId = $deanAccount ? $deanAccount->deans_profile_id : null;
        $deanProfile = DeanProfile::find($deanProfileId);
        $departmentName = $deanProfile ? $deanProfile->department->name : null;

        // Fetch teachers with approved grades
        $teachers = TeacherAccount::with('profile')->whereHas('profile.department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        })->whereHas('grades', function($q) {
            $q->where('status', 'approved');
        })->get();

        // Fetch subjects in department
        $subjects = Subject::whereHas('department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        })->get();

        // Fetch school years
        $schoolYears = SchoolYear::orderBy('schoolyear', 'desc')->get();

        return view('Dean.PostGrades.post', compact('subjects', 'teachers', 'schoolYears'));
    }

    public function fetchGrades(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school_year' => 'nullable|string',
            'semester' => 'nullable|string',
            'subject_id' => 'nullable|integer',
            'teacher_id' => 'nullable|integer',
            'term' => 'nullable|string|in:prelim,midterm,semi-final,final',
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
        $term = $request->input('term');

        $baseQuery = Grade::with(['student', 'subject', 'teacher'])->whereHas('subject.department', function($q) use ($departmentName) {
            $q->where('name', $departmentName);
        });

        // Only filter by approved status if no term is selected (for the table)
        if (!$term) {
            $baseQuery->where('status', 'approved');
        }

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

        $grades = $baseQuery->get();

        $mapGrade = function ($grade) use ($term) {
            $termGrade = null;
            $remarks = $grade->remarks;

            if ($term) {
                // Map term to the corresponding field
                $termFieldMap = [
                    'prelim' => 'prelim',
                    'midterm' => 'midterm',
                    'semi-final' => 'semi_final',
                    'final' => 'final',
                ];

                $field = $termFieldMap[$term] ?? null;
                if ($field) {
                    $termGrade = $grade->$field;
                    // Adjust remarks based on term grade
                    if ($termGrade !== null) {
                        $remarks = $termGrade >= 75 ? 'Passed' : 'Failed';
                    } else {
                        $remarks = 'Incomplete';
                    }
                }
            } else {
                $termGrade = $grade->term_grade;
            }

            return [
                'id' => $grade->id,
                'student_id' => $grade->student_id,
                'student_name' => $grade->student->name,
                'prelim' => $grade->prelim,
                'midterm' => $grade->midterm,
                'semi_final' => $grade->semi_final,
                'final' => $grade->final,
                'term_grade' => $termGrade,
                'remarks' => $remarks,
            ];
        };

        $result = $grades->map($mapGrade);

        return response()->json($result);
    }

    public function postGrade(Request $request)
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
        })->where('status', 'approved')->first();

        if (!$grade) {
            return response()->json(['error' => 'Grade not found or not eligible for posting'], 404);
        }

        $grade->status = 'posted';
        $grade->save();

        return response()->json(['success' => true, 'message' => 'Grade posted successfully']);
    }
}

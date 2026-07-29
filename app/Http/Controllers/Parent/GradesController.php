<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;
use App\Models\ParentProfile;
use App\Models\SchoolYear;

class GradesController extends Controller
{
    public function index()
    {
        $schoolYears = SchoolYear::orderBy('schoolyear', 'desc')->get();
        return view('parent.Final.Grades', compact('schoolYears'));
    }

    public function fetch(Request $request)
    {
        $parentId = Auth::guard('parent')->id();
        $parentAccount = \DB::table('parents_account')->where('id', $parentId)->first();
        $parentProfileId = $parentAccount ? $parentAccount->parents_profile_id : null;
        $parentProfile = ParentProfile::find($parentProfileId);

        $schoolYear = $request->input('school_year');
        $semester = $request->input('semester');

        $grades = collect();
        if ($parentProfile) {
            $studentIds = $parentProfile->students->pluck('users_id');

            $query = Grade::with(['student', 'subject.teacher'])
                ->whereIn('student_id', $studentIds)
                ->where('status', 'posted');

            if ($schoolYear) {
                $query->where('school_year', $schoolYear);
            }
            if ($semester) {
                $query->where('semester', $semester);
            }

            $grades = $query->get();
        }

        $result = $grades->map(function ($grade) {
            return [
                'subject_code' => $grade->subject->subject_code,
                'subject_name' => $grade->subject->subject_name,
                'units' => $grade->subject->units,
                'teacher_name' => $grade->subject->teacher ? $grade->subject->teacher->name : 'Not Assigned',
                'prelim' => $grade->prelim,
                'midterm' => $grade->midterm,
                'semi_final' => $grade->semi_final,
                'final' => $grade->final,
                'term_grade' => $grade->term_grade,
                'remarks' => $grade->remarks,
            ];
        });

        // Calculate GWA (simple average for now, can be weighted later)
        $totalGrade = $grades->sum('term_grade');
        $count = $grades->count();
        $gwa = $count > 0 ? round($totalGrade / $count, 2) : 0;

        return response()->json(['grades' => $result, 'gwa' => $gwa, 'debug' => ['parentId' => $parentId, 'parentProfileId' => $parentProfileId, 'studentIds' => $studentIds->toArray(), 'gradesCount' => $grades->count()]]);
    }
}

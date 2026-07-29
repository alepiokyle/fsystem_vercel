<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;
use App\Models\SchoolYear;
use App\Models\Subject;

class GradesController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();
        $schoolYears = SchoolYear::orderBy('schoolyear', 'desc')->get();
        $enrolledSubjects = Subject::whereHas('grades', function ($query) use ($studentId) {
            $query->where('student_id', $studentId)->where('status', 'posted');
        })->distinct()->get();
        return view('student.View.Grades', compact('schoolYears', 'enrolledSubjects'));
    }

    public function fetch(Request $request)
    {
        $studentId = Auth::id();
        $schoolYear = $request->input('school_year');
        $semester = $request->input('semester');
        $subjectId = $request->input('subject_id');
        $term = $request->input('term');

        $query = Grade::with(['subject.teacher'])
            ->where('student_id', $studentId)
            ->where('status', 'posted');

        if ($schoolYear) {
            $query->where('school_year', $schoolYear);
        }
        if ($semester) {
            $query->where('semester', $semester);
        }
        if ($subjectId) {
            $query->where('subject_id', $subjectId);
        }
        if ($term) {
            $query->whereNotNull($term);
        }

        $grades = $query->get();

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

        return response()->json(['grades' => $result, 'gwa' => $gwa]);
    }
}

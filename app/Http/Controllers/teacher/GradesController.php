<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;
use App\Models\Subject;

class GradesController extends Controller
{
    public function index()
    {
        $teacherId = Auth::guard('teacher')->id();
        $subjects = Subject::where('teacher_id', $teacherId)
            ->whereHas('students')
            ->get();

        return view('teacher.Submit.Grades', compact('subjects'));
    }

    public function fetchGrades(Request $request)
    {
        $teacherId = Auth::guard('teacher')->id();
        $subjectId = $request->input('subject_id');
        $term = $request->input('term');

        if (!$subjectId || !$term) {
            return response()->json(['error' => 'Subject and term are required'], 400);
        }

        $grades = Grade::where('teacher_id', $teacherId)
            ->where('subject_id', $subjectId)
            ->where('status', 'draft') // Only draft grades to be submitted
            ->with('student')
            ->get();

        $result = $grades->map(function ($grade) use ($term) {
            $termGrade = 0;
            switch (strtolower($term)) {
                case 'prelim':
                    $termGrade = $grade->prelim;
                    break;
                case 'midterm':
                    $termGrade = $grade->midterm;
                    break;
                case 'semi-final':
                case 'semi_final':
                    $termGrade = $grade->semi_final;
                    break;
                case 'final':
                    $termGrade = $grade->final;
                    break;
                default:
                    $termGrade = 0;
            }

            return [
                'student_name' => $grade->student->name,
                'term_grade' => $termGrade,
                'remarks' => '-', // Could be extended
                'status' => ucfirst($grade->status),
            ];
        });

        return response()->json($result);
    }

    public function submitGrades(Request $request)
    {
        $teacherId = Auth::guard('teacher')->id();
        $subjectId = $request->input('subject_id');

        if (!$subjectId) {
            return response()->json(['error' => 'Subject is required'], 400);
        }

        $grades = Grade::where('teacher_id', $teacherId)
            ->where('subject_id', $subjectId)
            ->where('status', 'draft')
            ->get();

        if ($grades->isEmpty()) {
            return response()->json(['error' => 'No draft grades to submit'], 400);
        }

        foreach ($grades as $grade) {
            $grade->status = 'pending';
            $grade->save();
        }

        // TODO: Notify Dean (future feature)

        return response()->json(['success' => true, 'message' => 'Grades submitted to Dean']);
    }
}

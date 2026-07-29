<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\Grade;

class TeacherController extends Controller
{
    public function index()
    {
        $teacherId = Auth::guard('teacher')->id();
        $subjects = Subject::where('teacher_id', $teacherId)->get();

        return view('teacher.Manages.assessment', compact('subjects'));
    }

    public function getStudents(Request $request, $subjectId)
    {
        $teacherId = Auth::guard('teacher')->id();
        $term = $request->query('term');
        $semester = $request->query('semester');

        $subject = Subject::where('id', $subjectId)
            ->where('teacher_id', $teacherId)
            ->with('students.profile')
            ->first();

        if (!$subject) {
            return response()->json(['error' => 'Subject not found'], 404);
        }

        // Ensure all students have a grade record for the selected semester
        foreach ($subject->students as $student) {
            $findData = [
                'student_id' => $student->id,
                'subject_id' => $subjectId,
                'teacher_id' => $teacherId,
            ];

            $createData = [
                'status' => 'draft',
                'school_year' => $subject->school_year,
                'semester' => $semester ?: $subject->semester,
            ];

            if ($semester) {
                $findData['semester'] = $semester;
            }

            Grade::firstOrCreate($findData, $createData);
        }

        $students = $subject->students->map(function ($student) use ($subjectId, $teacherId, $semester) {
            if (!$student->profile) {
                return null; // Skip students without profile
            }
            // Fetch existing grades for the semester
            $gradeQuery = Grade::where('student_id', $student->id)
                ->where('subject_id', $subjectId)
                ->where('teacher_id', $teacherId);

            if ($semester) {
                $gradeQuery->where('semester', $semester);
            }

            $grades = $gradeQuery->get();

            // Initialize grade values
            $prelim = null;
            $midterm = null;
            $semiFinal = null;
            $final = null;
            $termGrade = null;
            $remarks = '-';
            $status = 'draft';

            foreach ($grades as $grade) {
                $prelim = $grade->prelim ?: $prelim;
                $midterm = $grade->midterm ?: $midterm;
                $semiFinal = $grade->semi_final ?: $semiFinal;
                $final = $grade->final ?: $final;
                $termGrade = $grade->term_grade ?: $termGrade;
                $remarks = $grade->remarks !== '-' ? $grade->remarks : $remarks;
                $status = $grade->status !== 'draft' ? $grade->status : $status;
            }

            $profile = $student->profile;
            $fullName = $profile ? trim($profile->first_name . ' ' . ($profile->middle_name ? $profile->middle_name . ' ' : '') . $profile->last_name . ($profile->suffix ? ' ' . $profile->suffix : '')) : 'N/A';

            return [
                'id' => $student->id,
                'name' => $fullName,
                'prelim' => $prelim,
                'midterm' => $midterm,
                'semi_final' => $semiFinal,
                'final' => $final,
                'term_grade' => $termGrade,
                'remarks' => $remarks,
                'status' => $status,
            ];
        })->filter()->values(); // Remove null entries

        return response()->json($students);
    }

    public function saveGrades(Request $request, $subjectId)
    {
        try {
            $teacherId = Auth::guard('teacher')->id();
            $grades = $request->input('grades');
            $semester = $request->input('semester'); // Accept semester from request

            $subject = Subject::find($subjectId);
            if (!$subject || $subject->teacher_id != $teacherId) {
                return response()->json(['success' => false, 'error' => 'Subject not found or not authorized'], 404);
            }

            foreach ($grades as $studentId => $gradeData) {
                $existingGrade = Grade::where('student_id', $studentId)
                    ->where('subject_id', $subjectId)
                    ->where('teacher_id', $teacherId)
                    ->first();

                // Prevent editing if status is not draft
                if ($existingGrade && $existingGrade->status !== 'draft') {
                    continue;
                }

                $grade = Grade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'subject_id' => $subjectId,
                        'teacher_id' => $teacherId,
                    ],
                    [
                        'prelim' => isset($gradeData['prelim']) && $gradeData['prelim'] !== '' ? (float) $gradeData['prelim'] : null,
                        'midterm' => isset($gradeData['midterm']) && $gradeData['midterm'] !== '' ? (float) $gradeData['midterm'] : null,
                        'semi_final' => isset($gradeData['semi_final']) && $gradeData['semi_final'] !== '' ? (float) $gradeData['semi_final'] : null,
                        'final' => isset($gradeData['final']) && $gradeData['final'] !== '' ? (float) $gradeData['final'] : null,
                        'status' => 'draft',
                        'semester' => $semester ?: $subject->semester, // Use provided semester or fallback
                        'school_year' => $subject->school_year,
                    ]
                );

                // Calculate term_grade and remarks using weighted average: Prelim 20%, Midterm 30%, Semi-Final 20%, Final 30%
                $prelim = $grade->prelim ? (float) $grade->prelim : null;
                $midterm = $grade->midterm ? (float) $grade->midterm : null;
                $semiFinal = $grade->semi_final ? (float) $grade->semi_final : null;
                $final = $grade->final ? (float) $grade->final : null;

                if ($prelim !== null && $midterm !== null && $semiFinal !== null && $final !== null) {
                    $termGrade = ($prelim * 0.2) + ($midterm * 0.3) + ($semiFinal * 0.2) + ($final * 0.3);
                    $remarks = $termGrade >= 75 ? 'Passed' : 'Failed';
                } else {
                    $termGrade = null;
                    $remarks = 'Incomplete';
                }

                $grade->update([
                    'term_grade' => $termGrade,
                    'remarks' => $remarks,
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function submitGrades(Request $request, $subjectId)
    {
        $teacherId = Auth::guard('teacher')->id();

        $subject = Subject::find($subjectId);
        if (!$subject || $subject->teacher_id != $teacherId) {
            return response()->json(['error' => 'Subject not found or not authorized'], 404);
        }

        // Get total enrolled students
        $totalStudents = $subject->students()->count();

        // Count draft grades
        $draftGradesCount = Grade::where('subject_id', $subjectId)
            ->where('teacher_id', $teacherId)
            ->where('status', 'draft')
            ->count();

        // Check if all students have draft grades
        if ($draftGradesCount < $totalStudents) {
            return response()->json(['error' => 'Please save grades for all students before submitting.'], 400);
        }

        // Submit all draft grades
        $draftGrades = Grade::where('subject_id', $subjectId)
            ->where('teacher_id', $teacherId)
            ->where('status', 'draft')
            ->get();

        foreach ($draftGrades as $grade) {
            $grade->status = 'submitted';
            $grade->save();
        }

        // TODO: Notify Dean (future feature)

        return response()->json(['success' => true, 'message' => 'Grades submitted successfully to the Dean']);
    }

    public function saveFinalGradeFromSummary(Request $request, $subjectId)
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:users,id',
                'term' => 'required|in:prelim,midterm,semi,finals',
                'semester' => 'required|in:first,second',
                'final_grade' => 'required|numeric|min:0|max:100',
            ]);

            $teacherId = Auth::guard('teacher')->id();
            $studentId = $request->student_id;
            $term = $request->term;
            $semester = $request->semester;
            $finalGrade = $request->final_grade;

            $subject = Subject::find($subjectId);
            if (!$subject || $subject->teacher_id != $teacherId) {
                return response()->json(['success' => false, 'message' => 'Subject not found or not authorized'], 404);
            }

            // Map term to column name
            $termColumnMap = [
                'prelim' => 'prelim',
                'midterm' => 'midterm',
                'semi' => 'semi_final',
                'finals' => 'final',
            ];

            $termColumn = $termColumnMap[$term];

            // Find or create grade record
            $grade = Grade::firstOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                    'teacher_id' => $teacherId,
                ],
                [
                    'status' => 'draft',
                    'semester' => $semester,
                    'school_year' => $subject->school_year,
                ]
            );

            // Save the final grade to the specific term column
            $grade->update([
                $termColumn => round($finalGrade, 2),
                'term' => $term, // Store the selected term
            ]);

            // Recalculate term_grade and remarks if all term columns are filled
            $prelim = $grade->prelim ? (float) $grade->prelim : null;
            $midterm = $grade->midterm ? (float) $grade->midterm : null;
            $semiFinal = $grade->semi_final ? (float) $grade->semi_final : null;
            $final = $grade->final ? (float) $grade->final : null;

            if ($prelim !== null && $midterm !== null && $semiFinal !== null && $final !== null) {
                $termGrade = ($prelim * 0.2) + ($midterm * 0.3) + ($semiFinal * 0.2) + ($final * 0.3);
                $remarks = $termGrade >= 75 ? 'Passed' : 'Failed';
                $grade->update([
                    'term_grade' => round($termGrade, 2),
                    'remarks' => $remarks,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Final grade saved successfully']);
        } catch (\Exception $e) {
            \Log::error('Failed to save final grade from summary: ' . $e->getMessage(), [
                'subject_id' => $subjectId,
                'request' => $request->all(),
                'teacher_id' => Auth::guard('teacher')->id(),
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to save final grade. Please try again.'], 500);
        }
    }
}

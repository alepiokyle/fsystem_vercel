<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\Grade;

class AttendanceController extends Controller
{

    public function index()
    {
        $teacherId = Auth::guard('teacher')->id();
        $assignedSubjects = Subject::where('teacher_id', $teacherId)
            ->whereHas('students')
            ->get();

        $students = []; // Initialize empty array to prevent undefined variable error

        return view('teacher.Manage.attendance', compact('assignedSubjects', 'students'));
    }

    public function grading()
    {
        $teacherId = Auth::guard('teacher')->id();
        $assignedSubjects = Subject::where('teacher_id', $teacherId)
            ->whereHas('students')
            ->get();

        return view('teacher.grading', compact('assignedSubjects'));
    }

    public function getStudents(Request $request, $subjectId)
    {
        try {
            $subject = Subject::findOrFail($subjectId);

            // Check if the subject is assigned to the current teacher
            if ($subject->teacher_id != Auth::guard('teacher')->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to view students for this subject.'
                ], 403);
            }

            $students = $subject->students()->with(['profile.department'])->get()->map(function ($student) use ($request, $subject) {
                $profile = $student->profile;
                if (!$profile) {
                    return null; // Skip students without profile
                }
                $fullName = trim($profile->first_name . ' ' . ($profile->middle_name ? $profile->middle_name . ' ' : '') . $profile->last_name . ($profile->suffix ? ' ' . $profile->suffix : ''));
                $attendance = Attendance::where('student_id', $student->id)
                    ->where('subject_id', $subject->id)
                    ->where('date', $request->query('date'))
                    ->where('time', $request->query('time'))
                    ->first();

                return [
                    'id' => $student->id,
                    'student_id' => $profile->student_id,
                    'name' => $fullName,
                    'department' => $profile->department ? $profile->department->name : 'N/A',
                    'year_level' => $profile->year_level,
                    'status' => $attendance ? $attendance->status : null,
                ];
            })->filter()->values(); // Remove null entries

            return response()->json([
                'success' => true,
                'students' => $students,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to load students: ' . $e->getMessage(), [
                'subject_id' => $subjectId,
                'teacher_id' => Auth::guard('teacher')->id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load students. Please try again.'
            ], 500);
        }
    }

    public function getSubjectDetails($subjectId)
    {
        try {
            $subject = Subject::findOrFail($subjectId);

            // Check if the subject is assigned to the current teacher
            if ($subject->teacher_id != Auth::guard('teacher')->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to view this subject.'
                ], 403);
            }

            $teacherProfile = $subject->teacher->profile;
            $teacherName = trim($teacherProfile->first_name . ' ' . ($teacherProfile->middle_name ? $teacherProfile->middle_name . ' ' : '') . $teacherProfile->last_name . ($teacherProfile->suffix ? ' ' . $teacherProfile->suffix : ''));

            return response()->json([
                'success' => true,
                'subject' => [
                    'subject_code' => $subject->subject_code,
                    'subject_name' => $subject->subject_name,
                    'section' => $subject->section,
                    'teacher_name' => $teacherName,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load subject details. Please try again.'
            ], 500);
        }
    }

    public function getGradingStudents(Request $request, $subjectId)
    {
        try {
            $teacherId = Auth::guard('teacher')->id();
            if (!$teacherId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication error. Please log in as a teacher.'
                ], 401);
            }

            $subject = Subject::find($subjectId);
            if (!$subject) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subject not found.'
                ], 404);
            }

            // Check if the subject is assigned to the current teacher
            if ($subject->teacher_id != $teacherId) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to view students for this subject.'
                ], 403);
            }

            $term = $request->query('term');
            $semester = $request->query('semester');

            $students = $subject->students()->with(['profile.department'])->get()->unique('id')->map(function ($student) use ($subject, $teacherId, $term, $semester) {
                try {
                    $profile = $student->profile;
                    if (!$profile) {
                        return null; // Skip students without profile
                    }
                    $fullName = trim($profile->first_name . ' ' . ($profile->middle_name ? $profile->middle_name . ' ' : '') . $profile->last_name . ($profile->suffix ? ' ' . $profile->suffix : ''));

                    // Fetch existing grade record
                    $gradeQuery = Grade::where('student_id', $student->id)
                        ->where('subject_id', $subject->id)
                        ->where('teacher_id', $teacherId);
                    if ($term) {
                        $gradeQuery->where('term', $term);
                    }
                    if ($semester) {
                        $gradeQuery->where('semester', $semester);
                    }
                    $grade = $gradeQuery->first();

                    // Calculate attendance score (percentage of present days)
                    $totalAttendanceDays = Attendance::where('student_id', $student->id)
                        ->where('subject_id', $subject->id)
                        ->count();

                    $presentDays = Attendance::where('student_id', $student->id)
                        ->where('subject_id', $subject->id)
                        ->where('status', 'Present')
                        ->count();

                    $attendanceScore = $totalAttendanceDays > 0 ? ($presentDays / $totalAttendanceDays) * 100 : null;

                    return [
                        'id' => $student->id,
                        'name' => $fullName,
                        'student_id' => $profile->student_id,
                        'department' => $profile->department ? $profile->department->name : 'N/A',
                        'year_level' => $profile->year_level,
                        'quiz' => $grade ? $grade->quiz : null,
                        'total_quiz' => $grade ? $grade->total_quiz : null,
                        'assignment' => $grade ? $grade->assignment : null,
                        'total_assignment' => $grade ? $grade->total_assignment : null,
                        'attendance_score' => $attendanceScore,
                        'total_attendance_score' => $totalAttendanceDays > 0 ? 100 : null,
                        'exam' => $grade ? $grade->exam : null,
                        'total_exam' => $grade ? $grade->total_exam : null,
                        'performance' => $grade ? $grade->performance : null,
                        'total_performance' => $grade ? $grade->total_performance : null,
                        'final_grade' => $grade ? $grade->term_grade : null,
                        'is_done' => $grade ? $grade->is_done : false,
                    ];
                } catch (\Exception $e) {
                    Log::error('Error processing student ' . $student->id . ' in getGradingStudents: ' . $e->getMessage());
                    return null; // Skip problematic students
                }
            })->filter()->values(); // Remove null entries

            return response()->json([
                'success' => true,
                'students' => $students,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to load grading students: ' . $e->getMessage(), [
                'subject_id' => $subjectId,
                'teacher_id' => Auth::guard('teacher')->id(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to load students. Please try again.'
            ], 500);
        }
    }

    public function saveGradingComponent(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'component' => 'required|in:quiz,assignment,attendance_score,exam,performance',
            'student_id' => 'required|exists:users,id',
            'score' => 'nullable|numeric|min:0|max:100',
            'total' => 'nullable|numeric|min:1',
            'term' => 'nullable|in:prelim,midterm,semi,finals',
            'semester' => 'nullable|in:first,second',
        ]);

        $subjectId = $request->subject_id;
        $component = $request->component;
        $studentId = $request->student_id;
        $score = $request->score;
        $total = $request->total;
        $term = $request->term;
        $semester = $request->semester;
        $teacherId = Auth::guard('teacher')->id();

        // Check if subject is assigned to teacher
        $subject = Subject::findOrFail($subjectId);
        if ($subject->teacher_id != $teacherId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to save grades for this subject.'
            ], 403);
        }

        if (!$semester) {
            $semester = $subject->semester;
        }

        try {
            // Ensure grade record exists per term and semester
            $grade = Grade::firstOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                    'teacher_id' => $teacherId,
                    'term' => $term,
                    'semester' => $semester,
                ],
                [
                    'status' => 'draft',
                    'school_year' => $subject->school_year,
                ]
            );

            // Update the specific component and term/semester if provided
            $updateData = [
                $component => $score,
                "total_{$component}" => $total,
            ];
            if ($term) {
                $updateData['term'] = $term;
            }
            if ($semester) {
                $updateData['semester'] = $semester;
            }
            $grade->update($updateData);

            // Recalculate final grade if all components are present
            $components = ['quiz', 'assignment', 'attendance_score', 'exam', 'performance'];
            $allPresent = true;
            $finalGrade = 0;

            foreach ($components as $comp) {
                if ($grade->$comp === null || $grade->{"total_{$comp}"} === null || $grade->{"total_{$comp}"} == 0) {
                    $allPresent = false;
                    break;
                }
                $percentage = ($grade->$comp / $grade->{"total_{$comp}"}) * 100;
                $weight = in_array($comp, ['quiz', 'assignment', 'attendance_score']) ? 0.10 : ($comp === 'exam' ? 0.30 : 0.40);
                $finalGrade += $percentage * $weight;
            }

            if ($allPresent) {
                $grade->update([
                    'term_grade' => round($finalGrade, 2),
                    'remarks' => $finalGrade >= 75 ? 'Passed' : 'Failed',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Score saved successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to save grading component: ' . $e->getMessage(), [
                'subject_id' => $subjectId,
                'component' => $component,
                'student_id' => $studentId,
                'teacher_id' => $teacherId,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save score. Please try again.'
            ], 500);
        }
    }

    public function saveAttendance(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'time' => 'required',
            'attendance' => 'required|array',
            'attendance.*' => 'in:Present,Absent,Late,Excused',
        ]);

        $subjectId = (int) $request->subject_id;
        $date = $request->date;
        $time = $request->time;
        $attendanceData = $request->attendance;
        $teacherId = (int) Auth::guard('teacher')->id();

        // Check if subject is assigned to teacher
        $subject = Subject::findOrFail($subjectId);
        if ($subject->teacher_id != $teacherId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to save attendance for this subject.'
            ], 403);
        }

        // Check if date is weekend
        $dayOfWeek = date('N', strtotime($date)); // 1=Monday, 7=Sunday
        if ($dayOfWeek >= 6) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance cannot be recorded on weekends.'
            ], 400);
        }

        try {
            // Get enrolled students for the subject
            $enrolledStudentIds = $subject->students()->pluck('id')->toArray();

            // Check if all students in attendance data are enrolled
            $invalidStudents = [];
            foreach ($attendanceData as $studentId => $status) {
                $studentId = (int) $studentId;
                if (!in_array($studentId, $enrolledStudentIds)) {
                    $invalidStudents[] = $studentId;
                }
            }

            if (!empty($invalidStudents)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Some students are not enrolled in this subject.'
                ], 400);
            }

            foreach ($attendanceData as $studentId => $status) {
                $studentId = (int) $studentId;
                Attendance::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'date' => $date,
                        'time' => $time,
                        'subject_id' => $subjectId,
                    ],
                    [
                        'status' => $status,
                        'teacher_id' => $teacherId,
                    ]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Attendance saved successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to save attendance: ' . $e->getMessage(), [
                'subject_id' => $subjectId,
                'date' => $date,
                'teacher_id' => $teacherId,
                'attendance_data' => $attendanceData,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save attendance. Please try again.'
            ], 500);
        }
    }

    public function getPastRecords(Request $request)
    {
        try {
            $teacherId = Auth::guard('teacher')->id();

            $records = Attendance::with(['student.profile', 'subject'])
                ->where('teacher_id', $teacherId)
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->get()
                ->map(function ($attendance) {
                    $profile = $attendance->student->profile;
                    if (!$profile) {
                        return null; // Skip if no profile
                    }
                    $fullName = trim($profile->first_name . ' ' . ($profile->middle_name ? $profile->middle_name . ' ' : '') . $profile->last_name . ($profile->suffix ? ' ' . $profile->suffix : ''));
                    return [
                        'date' => $attendance->date,
                        'time' => $attendance->time,
                        'student_id' => $profile->student_id,
                        'student_name' => $fullName,
                        'status' => $attendance->status,
                        'subject' => $attendance->subject ? $attendance->subject->subject_name : 'N/A',
                    ];
                })
                ->filter() // Remove null entries
                ->values(); // Reindex array

            return response()->json([
                'success' => true,
                'records' => $records,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load past records. Please try again. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function markAsDone(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'student_id' => 'required|exists:users,id',
        ]);

        $subjectId = $request->subject_id;
        $studentId = $request->student_id;
        $teacherId = Auth::guard('teacher')->id();

        // Check if subject is assigned to teacher
        $subject = Subject::findOrFail($subjectId);
        if ($subject->teacher_id != $teacherId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to save grades for this subject.'
            ], 403);
        }

        try {
            // Find the grade record
            $grade = Grade::where('student_id', $studentId)
                ->where('subject_id', $subjectId)
                ->where('teacher_id', $teacherId)
                ->first();

            if (!$grade) {
                return response()->json([
                    'success' => false,
                    'message' => 'Grade record not found.'
                ], 404);
            }

            // Recalculate final grade if all components are present
            $components = ['quiz', 'assignment', 'attendance_score', 'exam', 'performance'];
            $allPresent = true;
            $finalGrade = 0;

            foreach ($components as $comp) {
                if ($grade->$comp === null || $grade->{"total_{$comp}"} === null) {
                    $allPresent = false;
                    break;
                }
                $percentage = ($grade->$comp / $grade->{"total_{$comp}"}) * 100;
                $weight = in_array($comp, ['quiz', 'assignment', 'attendance_score']) ? 0.10 : ($comp === 'exam' ? 0.30 : 0.40);
                $finalGrade += $percentage * $weight;
            }

            if ($allPresent) {
                $grade->update([
                    'term_grade' => round($finalGrade, 2),
                    'remarks' => $finalGrade >= 75 ? 'Passed' : 'Failed',
                    'is_done' => 1,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'All grading components must be completed before marking as done.'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Student marked as done successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to mark as done: ' . $e->getMessage(), [
                'subject_id' => $subjectId,
                'student_id' => $studentId,
                'teacher_id' => $teacherId,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to mark as done. Please try again.'
            ], 500);
        }
    }

    public function saveFinalGrade(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'student_id' => 'required|exists:users,id',
            'term' => 'required|in:prelim,midterm,semi-final,final,term-grade',
            'semester' => 'required|in:first,second',
            'grade' => 'required|numeric|min:0|max:100',
        ]);

        $subjectId = $request->subject_id;
        $studentId = $request->student_id;
        $term = $request->term;
        $semester = $request->semester;
        $grade = $request->grade;
        $teacherId = Auth::guard('teacher')->id();

        // Check if subject is assigned to teacher
        $subject = Subject::findOrFail($subjectId);
        if ($subject->teacher_id != $teacherId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to save grades for this subject.'
            ], 403);
        }

        try {
            // Map term to column
            $columnMap = [
                'prelim' => 'prelim',
                'midterm' => 'midterm',
                'semi-final' => 'semi_final',
                'final' => 'final',
                'term-grade' => 'term_grade',
            ];
            $column = $columnMap[$term];

            // Ensure grade record exists per term and semester
            $gradeRecord = Grade::firstOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                    'teacher_id' => $teacherId,
                    'term' => $term,
                    'semester' => $semester,
                ],
                [
                    'status' => 'draft',
                    'school_year' => $subject->school_year,
                ]
            );

            // Update the specific term column
            $gradeRecord->update([$column => round($grade, 2)]);

            // If term-grade, update remarks
            if ($term === 'term-grade') {
                $remarks = $grade >= 75 ? 'Passed' : 'Failed';
                $gradeRecord->update(['remarks' => $remarks]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Final grade saved successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to save final grade: ' . $e->getMessage(), [
                'subject_id' => $subjectId,
                'student_id' => $studentId,
                'term' => $term,
                'teacher_id' => $teacherId,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save final grade. Please try again.'
            ], 500);
        }
    }
}

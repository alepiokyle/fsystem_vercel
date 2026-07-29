<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;

class ViewController extends Controller
{

    public function index()
    {
        $teacherId = Auth::guard('teacher')->id();
        $assignedSubjects = Subject::where('teacher_id', $teacherId)
            ->withCount('students')
            ->get()
            ->groupBy(function ($subject) {
                return $subject->subject_code . '|' . $subject->subject_name;
            })
            ->map(function ($group) {
                $first = $group->first();
                $first->students_count = $group->sum('students_count');
                return $first;
            });

        return view('teacher.ViewAssign.Viewsubject', compact('assignedSubjects'));
    }

    public function unassign($id)
    {
        try {
            $subject = Subject::findOrFail($id);

            // Check if the subject is assigned to the current teacher
            if ($subject->teacher_id != Auth::guard('teacher')->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to unassign this subject.'
                ], 403);
            }

            $subject->teacher_id = null;
            $subject->save();

            return response()->json([
                'success' => true,
                'message' => 'Subject unassigned successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to unassign subject. Please try again.'
            ], 500);
        }
    }

    public function getStudents($subjectId)
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

            $subjectCode = $subject->subject_code;
            $subjectName = $subject->subject_name;
            $teacherId = Auth::guard('teacher')->id();

            // Get all students from subjects with the same code and name assigned to this teacher
            $students = Subject::where('subject_code', $subjectCode)
                ->where('subject_name', $subjectName)
                ->where('teacher_id', $teacherId)
                ->with('students.profile.department')
                ->get()
                ->pluck('students')
                ->flatten()
                ->unique('id')
                ->map(function ($student) {
                    $profile = $student->profile;
                    $fullName = trim($profile->first_name . ' ' . ($profile->middle_name ? $profile->middle_name . ' ' : '') . $profile->last_name . ($profile->suffix ? ' ' . $profile->suffix : ''));
                    return [
                        'student_id' => $profile->student_id,
                        'full_name' => $fullName,
                        'department' => $profile->department ? $profile->department->name : 'N/A',
                        'year_level' => $profile->year_level,
                    ];
                });

            return response()->json([
                'success' => true,
                'students' => $students,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load students. Please try again.'
            ], 500);
        }
    }
}

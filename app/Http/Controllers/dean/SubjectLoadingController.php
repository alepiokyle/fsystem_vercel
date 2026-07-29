<?php

namespace App\Http\Controllers\dean;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Models\Subject;
use App\Models\User;

class SubjectLoadingController extends Controller
{
    public function index()
    {
        // Get the authenticated dean
        $dean = Auth::guard('dean')->user();

        // Get the dean's department name
        $departmentName = $dean->profile->department->name;

        // Fetch subjects filtered by the dean's department, ordered by creation date (newest first), then group by code and name to show unique
        $subjects = Subject::whereHas('department', function($q) use ($departmentName) {
                            $q->where('name', $departmentName);
                        })
                          ->orderBy('created_at', 'desc')
                          ->get()
                          ->groupBy(function ($subject) {
                              return $subject->subject_code . '|' . $subject->subject_name;
                          })
                          ->map(function ($group) {
                              return $group->first(); // Take the latest created
                          });

        // Fetch students in the dean's department
        $students = User::where('user_role_id', 7)
                        ->whereHas('profile.department', function($query) use ($departmentName) {
                            $query->where('name', $departmentName);
                        })
                        ->with('profile')
                        ->get();

        return view('Dean.SubjectLoading.loading', compact('subjects', 'students'));
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
     * Get subjects by department for AJAX
     */
    public function getSubjectsByDepartment($department)
    {
        $subjects = Subject::whereHas('department', function($q) use ($department) {
            $q->where('name', $department);
        })->get(['id', 'subject_code', 'subject_name']);

        return response()->json($subjects);
    }

    /**
     * Load students to a subject
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        $subject = Subject::findOrFail($request->subject_id);

        // Attach students to the subject, but skip if already attached
        $attachedCount = 0;
        foreach ($request->student_ids as $studentId) {
            try {
                $subject->students()->attach($studentId);
                $attachedCount++;
            } catch (QueryException $e) {
                // Skip if duplicate (already enrolled)
                if ($e->getCode() !== '23000') {
                    throw $e; // Re-throw if it's not a duplicate error
                }
            }
        }

        $message = $attachedCount > 0
            ? "Successfully loaded {$attachedCount} student(s) to the subject."
            : "All selected students are already enrolled in this subject.";

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}

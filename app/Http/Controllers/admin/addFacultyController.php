<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class addFacultyController extends Controller
{
    public function index()
    {
        return view('admin.faculty.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department' => 'required|string|max:255',
            'subject_code' => 'required|string|max:255',
            'subject_name' => 'required|string|max:255',
            'units' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'school_year' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        try {
            // Create the subject
            $subject = \App\Models\Subject::create([
                'department' => $validated['department'],
                'subject_code' => $validated['subject_code'],
                'subject_name' => $validated['subject_name'],
                'units' => $validated['units'],
                'description' => $request->input('description'),
                'school_year' => $validated['school_year'],
                'semester' => $validated['semester'],
                'status' => $validated['status'],
            ]);

            // Check if this is an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "✅ Subject '{$subject->subject_name}' has been successfully saved to the system!",
                    'subject' => $subject
                ]);
            }

            // Regular form submission
            return redirect()->route('admin.upload-subject')->with('success', 'Subject saved successfully.');

        } catch (\Exception $e) {
            // Handle errors
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while saving the subject. Please try again.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withErrors(['error' => 'An error occurred while saving the subject. Please try again.'])->withInput();
        }
    }
}

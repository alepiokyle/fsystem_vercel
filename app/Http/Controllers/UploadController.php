<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Department;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Debug: Log that this controller method is being called
        \Log::info('UploadController@index called - returning latest 10 subjects');

        $subjects = Subject::with('department')->latest()->get(); // Get latest subjects with department
        $departments = Department::whereNotIn('name', ['Law', 'Information Technology', 'School of Nursing'])->get(); // Get departments excluding specified ones
        return view('admin.uploadSubject.subject', compact('subjects', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Handle subject upload logic
        $validated = $request->validate([
            'department' => 'required|integer|exists:departments,id',
            'subject_code' => 'required|string|max:10',
            'subject_name' => 'required|string|max:255',
            'units' => 'required|integer|min:1',
            'year_level' => 'nullable|string|max:255',
            'section' => 'nullable|string|max:255',
            'semester' => 'required|string|max:255',
            'school_year' => 'required|string|max:20',
            'description' => 'nullable|string',
            'status' => 'required|string|max:255',
        ]);

        // Find the department by ID
        $department = Department::find($validated['department']);
        if (!$department) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid department selected.'
            ]);
        }

        // Check for existing subject with same code, name, and department
        $existing = Subject::where('subject_code', $validated['subject_code'])
            ->where('subject_name', $validated['subject_name'])
            ->where('department_id', $validated['department'])
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'A subject with the same code and name already exists in this department.'
            ]);
        }

        // Prepare data for creation
        unset($validated['department']);
        $validated['department_id'] = $department->id;

        $subject = Subject::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Subject uploaded successfully',
            'subject' => $subject
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return view('admin.uploadSubject.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('admin.uploadSubject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string|max:10',
            'subject_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $subject->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Subject updated successfully',
            'subject' => $subject
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Subject deleted successfully'
        ]);
    }
}

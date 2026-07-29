<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

class viewstudentController extends Controller
{
       public function index()
    {
        $students = User::with('profile')->where('user_role_id', 7)->get();
        return view('admin.studentAccount.student', compact('students'));
    }

    public function importPage()
    {
        return view('admin.studentAccount.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $import = new StudentImport;
        Excel::import($import, $request->file('file'));

        $failures = $import->getFailures();

        if (count($failures) > 0) {
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Row ' . $failure['row'] . ': ' . implode(', ', $failure['errors']);
            }
            return redirect()->back()->withErrors(['error' => 'Some rows failed to import: ' . implode('; ', $errorMessages)]);
        }

        return redirect()->route('view.student')->with('success', 'Students imported successfully.');
    }

    public function destroy($id)
    {
        $student = User::findOrFail($id);
        $profile = $student->profile;
        if ($profile) {
            $profile->delete();
        }
        $student->delete();

        return redirect()->route('view.student')->with('success', 'Student account and profile deleted successfully.');
    }
}

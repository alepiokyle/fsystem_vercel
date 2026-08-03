<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeanAccount;
use App\Models\DeanProfile;
use App\Models\TeacherAccount;
use App\Models\TeacherProfile;
use App\Models\UserRole;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ViewAddStaffController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'deans'); // Default to 'deans'

        $deans = collect();
        $teachers = collect();

        if ($filter === 'deans') {
            $deans = DeanAccount::with('profile')->get();
        }

        if ($filter === 'teachers') {
            $teachers = TeacherAccount::with('profile')->get();
        }

        return view('admin.AddStaff.addstaff', compact('deans', 'teachers', 'filter'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:deans_account,username|unique:teachers_account,username',
            'role' => 'required|in:Dean,Teacher',
            'department' => $request->role === 'Dean' ? 'required|string|max:255' : 'nullable|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        try {
            // Split full name into parts
            $nameParts = explode(' ', $validated['name']);
            $firstName = $nameParts[0] ?? '';
            $middleName = count($nameParts) > 2 ? $nameParts[1] : null;
            $lastName = count($nameParts) > 1 ? $nameParts[count($nameParts) - 1] : '';

            $department = null;
            if (!empty($validated['department'])) {
                $department = Department::firstOrCreate(['name' => $validated['department']]);
            }

            if ($validated['role'] === 'Teacher') {
                $userRole = UserRole::where('role', 'Teacher')->first();
                if (!$userRole) {
                    return redirect()->back()->withErrors(['role' => 'Teacher role not found. Please seed the database.']);
                }

                // Create teacher profile
                $profile = TeacherProfile::create([
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'department_id' => $department ? $department->id : null,
                ]);

                // Create teacher account
                TeacherAccount::create([
                    'teachers_profile_id' => $profile->id,
                    'name' => $validated['name'],
                    'username' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'user_role_id' => $userRole->id,
                    'is_active' => true,
                    'created_by' => Auth::guard('admin')->id(),
                ]);
            } else {
                // For Dean role, create both Dean and Teacher accounts with same credentials
                $deanUserRole = UserRole::where('role', 'Dean')->first();
                $teacherUserRole = UserRole::where('role', 'Teacher')->first();

                if (!$deanUserRole || !$teacherUserRole) {
                    return redirect()->back()->withErrors(['role' => 'Required roles not found. Please seed the database.']);
                }

                // Create dean profile
                $deanProfile = DeanProfile::create([
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'department_id' => $department->id,
                ]);

                // Create dean account
                DeanAccount::create([
                    'deans_profile_id' => $deanProfile->id,
                    'name' => $validated['name'],
                    'username' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'user_role_id' => $deanUserRole->id,
                    'is_active' => true,
                    'created_by' => Auth::guard('admin')->id(),
                ]);

                // Create corresponding teacher profile
                $teacherProfile = TeacherProfile::create([
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'department_id' => $department->id,
                ]);

                // Create corresponding teacher account with same credentials
                TeacherAccount::create([
                    'teachers_profile_id' => $teacherProfile->id,
                    'name' => $validated['name'],
                    'username' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'user_role_id' => $teacherUserRole->id,
                    'is_active' => true,
                    'created_by' => Auth::guard('admin')->id(),
                ]);
            }

            return redirect()->route('view.addstaff')->with('success', 'Staff account created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create staff account: ' . $e->getMessage()]);
        }
    }

    public function destroyDean($id)
    {
        $dean = DeanAccount::findOrFail($id);
        $profile = $dean->profile;
        $dean->delete();
        if ($profile) {
            $profile->delete();
        }

        return redirect()->route('view.addstaff')->with('success', 'Dean account and profile deleted successfully.');
    }

    public function destroyTeacher($id)
    {
        $teacher = TeacherAccount::findOrFail($id);
        $profile = $teacher->profile;
        $teacher->delete();
        if ($profile) {
            $profile->delete();
        }

        return redirect()->route('view.addstaff')->with('success', 'Teacher account and profile deleted successfully.');
    }

    public function suspendDean($id)
    {
        $dean = DeanAccount::findOrFail($id);
        $dean->is_active = !$dean->is_active;
        $dean->save();

        $status = $dean->is_active ? 'activated' : 'suspended';
        return redirect()->route('view.addstaff')->with('success', "Dean account $status successfully.");
    }

    public function suspendTeacher($id)
    {
        $teacher = TeacherAccount::findOrFail($id);
        $teacher->is_active = !$teacher->is_active;
        $teacher->save();

        $status = $teacher->is_active ? 'activated' : 'suspended';
        return redirect()->route('view.addstaff')->with('success', "Teacher account $status successfully.");
    }

    /*
    public function updateDean(Request $request, $id)
    {
        $dean = DeanAccount::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:deans_account,username,' . $dean->id,
            'department' => 'required|string|max:255',
        ]);

        // Split full name into parts
        $nameParts = explode(' ', $validated['name']);
        $firstName = $nameParts[0] ?? '';
        $middleName = count($nameParts) > 2 ? $nameParts[1] : null;
        $lastName = count($nameParts) > 1 ? $nameParts[count($nameParts) - 1] : '';

        $dean->name = $validated['name'];
        $dean->username = $validated['email'];
        $dean->save();

        $profile = $dean->profile;
        if ($profile) {
            $profile->first_name = $firstName;
            $profile->middle_name = $middleName;
            $profile->last_name = $lastName;
            $profile->department = $validated['department'];
            $profile->save();
        }

        return redirect()->route('view.addstaff')->with('success', 'Dean account updated successfully.');
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = TeacherAccount::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers_account,username,' . $teacher->id,
            'department' => 'nullable|string|max:255',
        ]);

        // Split full name into parts
        $nameParts = explode(' ', $validated['name']);
        $firstName = $nameParts[0] ?? '';
        $middleName = count($nameParts) > 2 ? $nameParts[1] : null;
        $lastName = count($nameParts) > 1 ? $nameParts[count($nameParts) - 1] : '';

        $teacher->name = $validated['name'];
        $teacher->username = $validated['email'];
        $teacher->save();

        $profile = $teacher->profile;
        if ($profile) {
            $profile->first_name = $firstName;
            $profile->middle_name = $middleName;
            $profile->last_name = $lastName;
            $profile->department = $validated['department'];
            $profile->save();
        }

        return redirect()->route('view.addstaff')->with('success', 'Teacher account updated successfully.');
    }
    */
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UsersProfile;
use App\Models\ParentProfile;
use App\Models\ParentAccount;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('userAuth.register');
    }

    public function view()
    {
        $studentUsername = session('student_username');
        $studentPassword = session('student_password');
        $parentUsername = session('parent_username');
        $parentPassword = session('parent_password');

        return view('userAuth.pre-registration', compact(
            'studentUsername',
            'studentPassword',
            'parentUsername',
            'parentPassword'
        ));
    }


    //code logic

    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'student_id'         => 'required|exists:imported_student_ids,student_id|unique:users_profile,student_id',
            'first_name'         => 'required',
            'last_name'          => 'required',
            'gender'             => 'required',
            'parent_first_name'  => 'required',
            'parent_last_name'   => 'required',
            'parent_contact'     => 'required',
            'relationship'       => 'required',
            'address'            => 'required',
        ]);

        $year = date('Y');

        /* ===========================
     * 1) CREATE PARENT PROFILE
     * =========================== */
        $parentProfile = ParentProfile::create([
            'first_name'     => $request->parent_first_name,
            'middle_name'    => $request->parent_middle_name ?? null,
            'last_name'      => $request->parent_last_name,
            'gender'         => $request->parent_gender ?? 'unspecified', // change to null if column is nullable
            'contact_number' => $request->parent_contact,
            'relationship'   => $request->relationship,
            'address'        => $request->address,
        ]);

        /* ===========================
     * 2) AUTO-GENERATE PARENT USERNAME (firstname + running no.)
     * =========================== */
        $firstName = ucfirst(strtolower($request->parent_first_name));

        $lastParent = ParentAccount::where('username', 'like', $firstName . '%')
            ->orderByDesc('username')
            ->first();

        if ($lastParent) {
            // kunin lahat ng digits after the firstName, then +1
            $lastNumber = intval(substr($lastParent->username, strlen($firstName)));
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        $parentUsername = $firstName . $nextNumber;

        /* ===========================
     * 3) CREATE PARENT ACCOUNT
     * =========================== */
        $parentAccount = ParentAccount::create([
            'parents_profile_id' => $parentProfile->id,
            'name'               => "{$request->parent_first_name} {$request->parent_last_name}",
            'username'           => $parentUsername,
            'user_role_id'       => 8, // parent role
            'password'           => Hash::make('123456'),
            'is_active'          => true,
        ]);

        /* ===========================
     * 4) AUTO-GENERATE STUDENT USERNAME (year-based)
     * =========================== */
        $lastStudent = User::where('username', 'like', $year . '%')
            ->orderByDesc('username')
            ->first();

        if ($lastStudent) {
            $lastNumber = intval(substr($lastStudent->username, -4));
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }
        $studentUsername = $year . $nextNumber;

        /* ===========================
     * 5) CREATE STUDENT USER
     * =========================== */
        $middleInitial = strtoupper(substr($request->middle_name, 0, 1)) . '.';
        $fullName = trim("{$request->first_name} {$middleInitial} {$request->last_name} {$request->suffix}");

        $studentUser = User::create([
            'name'         => $fullName,
            'username'     => $studentUsername,
            'password'     => Hash::make('123456'),
            'user_role_id' => 7, // student role
            'is_active'    => true,
        ]);

        /* ===========================
     * 6) CREATE STUDENT PROFILE
     * =========================== */
        $usersProfile = UsersProfile::create([
            'users_id'           => $studentUser->id,
            'parents_profile_id' => $parentProfile->id,
            'student_id'         => $request->student_id,
            'first_name'         => $request->first_name,
            'middle_name'        => $request->middle_name,
            'last_name'          => $request->last_name,
            'suffix'             => $request->suffix,
            'date_of_birth'      => $request->date_of_birth,
            'gender'             => $request->gender, // student gender
            'course'             => $request->course,
            'year_level'         => $request->year_level,
        ]);

        /* ===========================
     * 7) SET DEPARTMENT BASED ON COURSE
     * =========================== */
        $department = Department::where('name', $request->course)->first();
        if ($department) {
            $usersProfile->update(['department_id' => $department->id]);
        }

        /* ===========================
     * 7) PREVIEW SESSION
     * =========================== */
        session([
            'student_username' => $studentUsername,
            'student_password' => '123456',
            'parent_username'  => $parentUsername,
            'parent_password'  => '123456',
        ]);

        return redirect()->route('review')
            ->with('success', 'Student & Parent accounts created successfully!');
    }
}

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\dean\DeanController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminAccount;
use App\Models\AdminProfile;
use App\Models\UserRole;

Route::get('/', function () {
    return view('userAuth.login');
})->name('home');

Route::get('/register', [App\Http\Controllers\Auth\RegistrationController::class, 'index'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegistrationController::class, 'store'])->name('register.store');
Route::get('/registration/review', [App\Http\Controllers\Auth\RegistrationController::class, 'view'])->name('review');

// Authentication Routes
Route::get('/login', [App\Http\Controllers\Auth\loginController::class, 'create'])->name('login');
Route::post('/signin', [App\Http\Controllers\Auth\loginController::class, 'store'])->name('signin');
Route::post('/logout', [App\Http\Controllers\Auth\logoutController::class, 'userDestroy'])->name('logout');
Route::get('/suspended', function () {
    return view('auth.suspended');
})->name('suspended');

// Admin
Route::prefix('admin')->middleware('auth:admin')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\admin\adminDashboardController::class, 'index'])->name('admin.dashboard');

    // Upload Subject Routes - Fixed to use UploadController
    Route::controller(App\Http\Controllers\UploadController::class)->group(function () {
        Route::get('/upload-subject', 'index')->name('admin.upload-subject');
        Route::post('/upload-subject', 'store')->name('admin.upload-subject.store');
    });


     Route::controller(App\Http\Controllers\admin\GradeController::class)->group(function () {
        Route::get('/admin_Grade', 'index')->name('admin.Grade');
    });

    

    Route::controller(App\Http\Controllers\DeanController::class)->group(function () {
        Route::get('/view-dean', 'index')->name('view.dean');
    });

    Route::controller(App\Http\Controllers\admin\ViewTeacherController::class)->group(function () {
        Route::get('/view-teacher', 'index')->name('view.teacher');
    });

    Route::controller(App\Http\Controllers\admin\viewstudentController::class)->group(function () {
        Route::get('/view-student', 'index')->name('view.student');
        Route::get('/import-student', 'importPage')->name('admin.student.import.page');
        Route::post('/import-student', 'import')->name('admin.student.import');
        Route::delete('/student/{id}', 'destroy')->name('admin.student.destroy');
        Route::get('/download-sample-student', function () {
            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SampleStudentExport, 'Student_Summary.xlsx');
        })->name('admin.student.download.sample');
    });

    Route::controller(App\Http\Controllers\admin\ParentAccountController::class)->group(function () {
        Route::get('/view-parent', 'index')->name('view.parent');
        Route::delete('/parent/{id}', 'destroy')->name('admin.parent.destroy');
    });

    Route::controller(App\Http\Controllers\admin\ViewAddStaffController::class)->group(function () {
        Route::get('/view-addstaff', 'index')->name('view.addstaff');
        Route::post('/view-addstaff', 'store')->name('admin.addstaff.store');
        Route::delete('/dean/{id}', 'destroyDean')->name('admin.dean.destroy');
        Route::delete('/teacher/{id}', 'destroyTeacher')->name('admin.teacher.destroy');
        Route::patch('/dean/{id}/suspend', 'suspendDean')->name('admin.dean.suspend');
        Route::patch('/teacher/{id}/suspend', 'suspendTeacher')->name('admin.teacher.suspend');
    });

    Route::get('/uploadsubject', [App\Http\Controllers\admin\UploadSubjectController::class, 'index'])->name('admin.uploadsubject');
});

// Dean
Route::prefix('dean')->middleware('auth:dean')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\dean\DashboardController::class, 'index'])->name('Dean.deandashboard');

    Route::controller(App\Http\Controllers\dean\SwitchRoleController::class)->group(function () {
        Route::get('/switch-role', 'switchToTeacher')->name('dean.switch-role');
    });

    Route::controller(App\Http\Controllers\dean\AssignController::class)->group(function () {
        Route::get('/AssignTeacher', 'index')->name('dean.AssignTeacher');
        Route::post('/AssignTeacher', 'store')->name('dean.AssignTeacher.store');
        Route::delete('/AssignTeacher/{id}', 'destroy')->name('dean.AssignTeacher.destroy');
        Route::get('/AssignTeacher/check/{teacher_id}', 'checkAssignments')->name('dean.AssignTeacher.check');
        Route::get('/AssignTeacher/creator/{teacher_id}', 'getCreator')->name('dean.AssignTeacher.creator');
    });

    Route::controller(App\Http\Controllers\dean\SubjectLoadingController::class)->group(function () {
        Route::get('/SubjectLoading', 'index')->name('Dean.SubjectLoading');
        Route::post('/SubjectLoading', 'store')->name('Dean.SubjectLoading.store');
        Route::delete('/SubjectLoading/{id}', 'destroy')->name('Dean.SubjectLoading.destroy');
        Route::get('/get-subjects/{department}', 'getSubjectsByDepartment')->name('dean.getSubjectsByDepartment');
    });

    Route::controller(App\Http\Controllers\dean\ApproveGradesController::class)->group(function () {
        Route::get('/ApproveGrades', 'index')->name('Dean.ApproveGrades');
        Route::get('/ApproveGrades/fetch-grades', 'fetchGrades')->name('Dean.ApproveGrades.fetch-grades');
        Route::post('/ApproveGrades/approve', 'approveGrade')->name('Dean.ApproveGrades.approve');
        Route::post('/ApproveGrades/reject', 'rejectGrade')->name('Dean.ApproveGrades.reject');
        Route::get('/ApproveGrades/subjects-by-teacher/{teacher_id}', 'getSubjectsByTeacher')->name('Dean.ApproveGrades.subjects-by-teacher');
    });

    Route::controller(App\Http\Controllers\dean\PostGradesController::class)->group(function () {
        Route::get('/PostGrades', 'index')->name('Dean.PostGrades');
        Route::get('/PostGrades/fetch-grades', 'fetchGrades')->name('Dean.PostGrades.fetch-grades');
        Route::post('/PostGrades/post', 'postGrade')->name('Dean.PostGrades.post');
    });
});

// Teacher
Route::prefix('teacher')->middleware('auth:teacher')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\teacher\TeacherDashboardController::class, 'index'])->name('teacher.teacherdashboard');

    Route::controller(App\Http\Controllers\dean\SwitchRoleController::class)->group(function () {
        Route::get('/switch-role', 'switchToDean')->name('teacher.switch-role');
    });

    Route::controller(App\Http\Controllers\teacher\ViewController::class)->group(function () {
        Route::get('/ViewAssign', 'index')->name('teacher.ViewAssign');
        Route::delete('/ViewAssign/{id}', 'unassign')->name('teacher.ViewAssign.unassign');
        Route::get('/ViewAssign/{id}/students', 'getStudents')->name('teacher.ViewAssign.students');
    });

    Route::controller(App\Http\Controllers\teacher\AttendanceController::class)->group(function () {
        Route::get('/Manage', 'index')->name('teacher.Manage');
        Route::get('/Manage/{subjectId}/students', 'getStudents')->name('teacher.Manage.students');
        Route::post('/Manage/save-attendance', 'saveAttendance')->name('teacher.Manage.save-attendance');
        Route::get('/Manage/past-records', 'getPastRecords')->name('teacher.Manage.past-records');
        Route::get('/Manage/{subjectId}/subject-details', 'getSubjectDetails')->name('teacher.Manage.subject-details');
        Route::get('/Manage/{subjectId}/grading-students', 'getGradingStudents')->name('teacher.Manage.grading-students');
        Route::post('/Manage/save-grading-component', 'saveGradingComponent')->name('teacher.Manage.save-grading-component');
        Route::post('/Manage/save-final-grade', 'saveFinalGrade')->name('teacher.Manage.save-final-grade');
        Route::post('/Manage/mark-as-done', 'markAsDone')->name('teacher.Manage.mark-as-done');
        Route::get('/grading', 'grading')->name('teacher.grading');
    });

    Route::controller(App\Http\Controllers\teacher\TeacherController::class)->group(function () {
        Route::get('/Manages', 'index')->name('teacher.Manages');
        Route::get('/Manages/{subjectId}/students', 'getStudents')->name('teacher.Manages.students');
        Route::post('/Manages/{subjectId}/save-grades', 'saveGrades')->name('teacher.Manages.save-grades');
        Route::post('/Manages/{subjectId}/submit-grades', 'submitGrades')->name('teacher.Manages.submit-grades');
        Route::post('/Manages/{subjectId}/save-final-grade-from-summary', 'saveFinalGradeFromSummary')->name('teacher.Manages.save-final-grade-from-summary');
    });

    Route::controller(App\Http\Controllers\teacher\GradesController::class)->group(function () {
        Route::get('/Submit', 'index')->name('teacher.Grades');
        Route::post('/Submit/fetch-grades', 'fetchGrades')->name('teacher.Submit.fetch-grades');
        Route::post('/Submit/submit-grades', 'submitGrades')->name('teacher.Submit.submit-grades');
    });
});

// Student
Route::prefix('student')->middleware('auth:web')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\StudentDashboardController::class, 'index'])->name('student.studentdashboard');

    Route::controller(App\Http\Controllers\Student\GradesController::class)->group(function () {
        Route::get('/grades', 'index')->name('student.grades');
        Route::get('/grades/fetch', 'fetch')->name('student.grades.fetch');
    });
});

Route::controller(App\Http\Controllers\Student\SubjectController::class)->group(function () {
    Route::get('/Subject', 'index')->name('student.Subject');
});

Route::controller(App\Http\Controllers\Student\NotifController::class)->group(function () {
    Route::get('/Notif', 'index')->name('student.Notif');
});

Route::middleware('auth:web')->controller(App\Http\Controllers\Student\SectionController::class)->group(function () {
    Route::get('/Section', 'index')->name('student.Section');
    Route::post('/upload-profile-picture', 'uploadProfilePicture')->name('student.updateProfile');
});

// Parent
Route::prefix('parent')->middleware('auth:parent')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\parent\parentDashboardController::class, 'index'])->name('parent.parentdashboard');

    Route::controller(App\Http\Controllers\parent\AttendanceController::class)->group(function () {
        Route::get('/Attendance', 'index')->name('parent.Attendance');
        Route::get('/attendance/fetch', 'fetch')->name('parent.attendance.fetch');
    });

    Route::controller(App\Http\Controllers\parent\NotesController::class)->group(function () {
        Route::get('/Notes', 'index')->name('parent.Notes');
    });

    Route::controller(App\Http\Controllers\parent\ExamController::class)->group(function () {
        Route::get('/Exam', 'index')->name('parent.Exam');
    });

    Route::controller(App\Http\Controllers\parent\GradesController::class)->group(function () {
        Route::get('/Grades', 'index')->name('parent.Grades');
        Route::get('/Grades/fetch', 'fetch')->name('parent.Grades.fetch');
    });
});

// Temporary route to force-create admin account directly in PostgreSQL
Route::get('/force-seed-admin', function () {
    try {
        // Ensure Admin Role Exists
        UserRole::updateOrCreate(
            ['id' => 4],
            ['role' => 'Admin']
        );

        // Ensure Profile Exists
        $profile = AdminProfile::firstOrCreate(
            ['first_name' => 'System'],
            ['middle_name' => null, 'last_name' => 'Admin']
        );

        // Create or update PACAdmin
        AdminAccount::updateOrCreate(
            ['username' => 'PACAdmin'],
            [
                'name' => 'PAC Admin',
                'admins_profile_id' => $profile->id,
                'password' => Hash::make('123456'),
                'user_role_id' => 4,
                'is_active' => 1,
            ]
        );

        // Fallback lowercase pacadmin
        AdminAccount::updateOrCreate(
            ['username' => 'pacadmin'],
            [
                'name' => 'PAC Admin',
                'admins_profile_id' => $profile->id,
                'password' => Hash::make('123456'),
                'user_role_id' => 4,
                'is_active' => 1,
            ]
        );

        return 'SUCCESS: PACAdmin and pacadmin accounts created! Password is set to 123456.';
    } catch (\Exception $e) {
        return 'ERROR: ' . $e->getMessage();
    }
});
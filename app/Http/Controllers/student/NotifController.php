<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;

class NotifController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();

        // Fetch posted grades for the student (consider them as new notifications)
        $notifications = Grade::with(['subject'])
            ->where('student_id', $studentId)
            ->where('status', 'posted')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($grade) {
                return [
                    'id' => $grade->id,
                    'title' => 'New Grade Posted',
                    'message' => "Your grade in {$grade->subject->subject_code} ({$grade->subject->subject_name}) has been approved and posted.",
                    'time' => $grade->updated_at->diffForHumans(),
                    'is_read' => false, // Placeholder; can implement read status later
                ];
            });

        return view('student.Notification.Notif', compact('notifications'));
    }
}

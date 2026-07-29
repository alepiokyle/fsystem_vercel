<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ParentProfile;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $parentId = Auth::guard('parent')->id();
        $parentAccount = \DB::table('parents_account')->where('id', $parentId)->first();
        $parentProfileId = $parentAccount ? $parentAccount->parents_profile_id : null;
        $parentProfile = ParentProfile::find($parentProfileId);

        $students = collect();
        if ($parentProfile) {
            $students = $parentProfile->students;
        }

        return view('parent.child.Attendance', compact('students'));
    }

    public function fetch(Request $request)
    {
        $studentId = $request->input('student_id');
        $month = $request->input('month'); // e.g., '2025-08'

        // Parse month to get year and month
        $date = Carbon::createFromFormat('Y-m', $month);
        $year = $date->year;
        $monthNum = $date->month;

        // Query attendances for the student in the specified month
        $attendances = Attendance::where('student_id', $studentId)
            ->whereYear('date', $year)
            ->whereMonth('date', $monthNum)
            ->orderBy('date', 'asc')
            ->get();

        // Calculate summary
        $total = $attendances->count();
        $present = $attendances->where('status', 'present')->count();
        $absent = $attendances->where('status', 'absent')->count();
        $late = $attendances->where('status', 'late')->count();
        $rate = $total > 0 ? round(($present / $total) * 100, 1) : 0;

        $summary = [
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
            'rate' => $rate,
        ];

        // Format attendances for response
        $formattedAttendances = $attendances->map(function ($attendance) {
            $statusColor = match ($attendance->status) {
                'present' => 'success',
                'absent' => 'danger',
                'late' => 'warning',
                default => 'secondary',
            };

            return [
                'date' => $attendance->date->format('F j, Y'),
                'status' => ucfirst($attendance->status),
                'status_color' => $statusColor,
                'remarks' => $attendance->remarks ?? '-',
            ];
        });

        return response()->json([
            'summary' => $summary,
            'attendances' => $formattedAttendances,
        ]);
    }
}

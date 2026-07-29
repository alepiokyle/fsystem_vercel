<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;
use App\Models\ParentProfile;

class NotesController extends Controller
{
    public function index()
    {
        $parentId = Auth::guard('parent')->id();
        $parentAccount = \DB::table('parents_account')->where('id', $parentId)->first();
        $parentProfileId = $parentAccount ? $parentAccount->parents_profile_id : null;
        $parentProfile = ParentProfile::find($parentProfileId);

        $children = collect();
        if ($parentProfile) {
            $studentIds = $parentProfile->students->pluck('users_id');
            foreach ($studentIds as $studentId) {
                $student = \DB::table('users')->where('id', $studentId)->first();
                if ($student) {
                    $grades = Grade::where('student_id', $studentId)
                        ->where('status', 'posted')
                        ->get();

                    $average = $grades->count() > 0 ? $grades->avg('term_grade') : 0;

                    $behavior = $this->getBehaviorMessage($average);

                    $children->push([
                        'name' => $student->name,
                        'average' => round($average, 2),
                        'behavior_title' => $behavior['title'],
                        'behavior_message' => $behavior['message'],
                        'alert_class' => $behavior['alert_class'],
                        'remark' => $behavior['remark'],
                    ]);
                }
            }
        }

        return view('parent.Behavior.Notes', compact('children'));
    }

    private function getBehaviorMessage($average)
    {
        if ($average < 75) {
            return [
                'title' => 'Needs Improvement',
                'message' => 'Needs improvement in behavior due to low grades.',
                'alert_class' => 'alert-danger',
                'remark' => 'Encourage better focus and study habits.',
            ];
        } elseif ($average >= 80 && $average <= 85) {
            return [
                'title' => 'Good Work',
                'message' => 'Keep up the good work!',
                'alert_class' => 'alert-warning',
                'remark' => 'Continue with consistent effort.',
            ];
        } elseif ($average >= 90 && $average <= 99) {
            return [
                'title' => 'Excellent',
                'message' => 'Excellent performance! Keep it up!',
                'alert_class' => 'alert-success',
                'remark' => 'Outstanding academic achievement.',
            ];
        } else {
            return [
                'title' => 'Average',
                'message' => 'Performing at an average level.',
                'alert_class' => 'alert-info',
                'remark' => 'Room for improvement in some areas.',
            ];
        }
    }
}

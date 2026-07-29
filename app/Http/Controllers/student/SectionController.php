<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsersProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = UsersProfile::with(['user', 'department'])->where('users_id', $user->id)->first();

        return view('student.Profile.Section', compact('profile'));
    }

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $profile = UsersProfile::where('users_id', $user->id)->first();

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($profile->profile_picture && Storage::disk('public')->exists('profile_pictures/' . $profile->profile_picture)) {
                Storage::disk('public')->delete('profile_pictures/' . $profile->profile_picture);
            }

            // Create user-specific folder path
            $userFolder = $user->id;
            $fileName = time() . '_' . $user->id . '.' . $request->file('profile_picture')->getClientOriginalExtension();
            $relativePath = $userFolder . '/' . $fileName;

            // Store new image in user folder
            $path = $request->file('profile_picture')->storeAs('profile_pictures/' . $userFolder, $fileName, 'public');

            // Update profile with relative path
            $profile->update(['profile_picture' => $relativePath]);

            return response()->json([
                'success' => true,
                'image_url' => asset('storage/profile_pictures/' . $relativePath),
                'message' => 'Profile picture updated successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded.'
        ]);
    }
}

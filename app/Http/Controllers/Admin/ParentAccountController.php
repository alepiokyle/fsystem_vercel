<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParentAccount;

class ParentAccountController extends Controller
{
    public function index()
    {
        $parents = ParentAccount::with('profile.students.user')->get();

        return view('admin.parentAccount.parent', compact('parents'));
    }

    public function destroy($id)
    {
        $parent = ParentAccount::findOrFail($id);
        $profile = $parent->profile;
        if ($profile) {
            $profile->delete();
        }
        $parent->delete();

        return redirect()->route('view.parent')->with('success', 'Parent account and profile deleted successfully.');
    }
}

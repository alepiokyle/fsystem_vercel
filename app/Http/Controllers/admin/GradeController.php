<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::where('status', 'approved')
            ->with(['student', 'subject', 'teacher'])
            ->get();

        return view('admin.Views.Grade', compact('grades'));
    }
}

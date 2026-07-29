<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
{
       public function index()
    {
        return view('parent.Quiz.Exam');
    }
}

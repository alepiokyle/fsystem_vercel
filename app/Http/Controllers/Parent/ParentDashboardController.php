<?php

namespace App\Http\Controllers\parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParentDashboardController extends Controller
{
    public function index()
    {
        return view('parent.parentdashboard');
    }
}

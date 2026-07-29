<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeanController extends Controller
{
    public function index()
    {
        return view('admin.deanAccount.dean'); // Update this line
    }
}

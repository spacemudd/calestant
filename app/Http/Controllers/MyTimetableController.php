<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyTimetableController extends Controller
{
    function index()
    {
        return view('my-timetable.index');
    }
}

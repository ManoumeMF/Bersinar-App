<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(){
        return view('admin.Schedule.index');
    }
    public function create(){
        return view('admin.Schedule.create');
    }
}

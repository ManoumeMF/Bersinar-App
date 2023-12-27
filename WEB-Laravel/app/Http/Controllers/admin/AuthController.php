<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
        return view('layouts.admin.auth');
    }

    public function dashboard(){
        return view('layouts.admin.dashboard');
    }

    public function login(){
        return view('layouts.admin.auth');
    }
}

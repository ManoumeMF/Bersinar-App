<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OfftakerController extends Controller
{
    public function index(){
        return view('admin.DataMaster.offtaker.index');
    }

    public function create(){
        return view('admin.DataMaster.offtaker.create');
    }
}
<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EmployeePersonalController extends Controller
{
    public function index(){
        $response = Http::get(config('app.api_url'). 'employeePersonal/viewAll');
        $employeePersonal = $response->json();
        return view('admin.DataMaster.employee.index', compact('employeePersonal'));
    }

    public function create(){
        return view('admin.DataMaster.employee.create');
    }

    public function store(Request $request){

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function loadEmployeeHome(){
        return view('employee.home-page');
    }
}
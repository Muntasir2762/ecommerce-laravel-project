<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function dashboard ()
    {
        return view('employee.employee-dashboard');
    }

    public function employeeLogout ()
    {
        Auth::logout();
        return redirect('/employee/login');
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function adminLogin ()
    {
        return view('auth.login.adminlogin');
    }

    public function adminLoginAuth (Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('/admin/dashboard');
        }
        else{
            return redirect()->back();
        }
    }

    public function employeeLogin ()
    {
        return view('auth.login.employeelogin');
    }

    public function employeeLoginAuth (Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('/employee/dashboard');
        }
        else{
            return redirect()->back();
        }
    }

    public function customerLogin ()
    {
        return view('auth.login.customerlogin');
    }

    public function customerLoginAuth (Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('/customer/dashboard');
        }
        else{
            return redirect()->back();
        }
    }
}

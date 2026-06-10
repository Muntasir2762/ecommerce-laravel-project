<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

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
            // return redirect('/employee/dashboard');
            return redirect('/admin/dashboard');
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
            if(Auth::user()->role == 'customer'){
                return redirect('/customer/dashboard');
            }
            else{
                $role = Auth::user()->role;
                Auth::logout();
                if($role == 'admin'){
                    return redirect('/admin/login');
                }
                elseif($role == 'employee'){
                    return redirect('/employee/login');
                }
            }
        }
        else{
            return redirect()->back();
        }
    }

    public function customerRegistration ()
    {
        return view('auth.login.customer-registration');
    }

    public function customerRegistrationStore (Request $request)
    {
        $customer = new User();

        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password);
        $customer->role = 'customer';

        $customer->save();

        toastr()->success('Account created successfully');
        return redirect('customer/login');


    }
}

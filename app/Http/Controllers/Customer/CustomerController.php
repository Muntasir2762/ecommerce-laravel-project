<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard ()
    {
        return view('customer.customer-dashboard');
    }

    public function customerLogout ()
    {
        Auth::logout();
        return redirect('/customer/login');
    }

    public function customerProfileView ()
    {
        $authUser = Auth::user();
        return view('customer.profile.profile-view', compact('authUser'));
    }

    public function customerProfileUpdate (Request $request)
    {
        $authUserId = Auth::user()->id;

        $authUser = User::find($authUserId);

        $authUser->name = $request->name;
        $authUser->phone = $request->phone;

        $authUser->save();

        toastr()->success('Profile Updated Successfully');
        return redirect()->back();
    }
}

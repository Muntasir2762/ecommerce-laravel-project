<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        if(isset($request->image)){

            if($authUser->image && file_exists('customer/profile/'.basename($authUser->image))){
                unlink('customer/profile/'.basename($authUser->image));
            }

            $image = $request->file('image');
            $imageName = rand().'.'.$image->getClientOriginalExtension(); //4347657.jpg
            $image->move('customer/profile', $imageName);

            $authUser->image = url('customer/profile/'.$imageName); //http://127.0.0.1:8000/admin/category/4347657.jpg
        }

        $authUser->save();

        toastr()->success('Profile Updated Successfully');
        return redirect()->back();
    }

    public function customerCredentialView ()
    {
        $authUser = Auth::user();
        return view('customer.profile.credential-view', compact('authUser'));
    }

    public function customerCredentialUpdate (Request $request)
    {
        $authUserId = Auth::user()->id;

        $authUser = User::find($authUserId);

        if(isset($request->email)){
            $authUser->email = $request->email;
        }

        if(isset($request->old_password) && isset($request->password)){
            if(Hash::check($request->old_password, $authUser->password)){ 
                $authUser->password = Hash::make($request->password);
            }
            else{
                toastr()->error("Old password doesn't match");
                return redirect()->back();
            }
        }

        $authUser->save();
        Auth::logout();

        toastr()->success("Credential updated successfully");
        return redirect()->back();
    }

    public function customerOrders ($status)
    {
        if($status == 'all'){
            $orders = Order::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->get();
        }
        else{
            $orders = Order::orderBy('id', 'desc')->where('status',$status)->where('user_id', Auth::user()->id)->get();
        }
        //dd($orders);
        return view('customer.order.list', compact('orders'));
    }
}

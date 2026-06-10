<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard ()
    {
        $allOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $returnedOrders = Order::where('status', 'returned')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        return view('admin.admin-dashboard', compact('allOrders', 
        'pendingOrders', 'confirmedOrders', 
        'deliveredOrders', 'returnedOrders', 'cancelledOrders'));
    }

    public function adminLogout ()
    {
        $role = Auth::user()->role;
        Auth::logout();

        if($role == 'admin'){
            return redirect('/admin/login');
        }
        else{
            return redirect('/employee/login');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showOrders ($status)
    {
        if($status == 'all'){
            $orders = Order::orderBy('id', 'desc')->with('orderDetails')->paginate(50);
        }
        else{
            $orders = Order::orderBy('id', 'desc')->with('orderDetails')->where('status', $status)->paginate(50);
        }
        return view('admin.order.list', compact('orders'));
    }
}

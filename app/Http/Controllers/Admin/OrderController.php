<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
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

    public function detailOrder ($id)
    {
        $order = Order::with('orderDetails')->where('id', $id)->first();
        return view('admin.order.edit', compact('order'));
    }

    public function updateOrder (Request $request, $id)
    {
        $order = Order::find($id);

        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->charge = $request->charge;
        $order->address = $request->address;
        $order->courier_name = $request->courier_name;
        $order->price = $request->price;

        $order->save();

        toastr()->success('Order updated successfully');
        return redirect()->back();
    }

    public function updateOrderDetails (Request $request, $id)
    {
        $orderDetails = OrderDetails::find($id);

        $orderDetails->qty = $request->qty;
        $orderDetails->color = $request->color;
        $orderDetails->size = $request->size;

        $orderDetails->save();
        // return redirect()->back();
        return response()->json('Updated successfully');
    }
}

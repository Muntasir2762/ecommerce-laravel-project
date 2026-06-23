<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function updateOrderStatus (Request $request, $id)
    {
        $order = Order::find($id);
        $order->status = $request->status;

        $order->save();
        return redirect()->back();
    }

    public function courierEntry ($order_id)
    {
        $order = Order::find($order_id);

        if($order->courier_name == 'steadfast'){
            $apiEndpoint = "https://portal.packzy.com/api/v1/create_order";

            $header = [
                'Api-Key' => "",
                'Secret-Key' => "",
                'Content-Type' => ""
            ];

            //Body Parametres...
            $invoiceNumber = $order->invoice_number;
            $customerName = $order->name;
            $customerPhone = $order->phone;
            $customerAddress = $order->address;
            $price = $order->price;

            $payLoad = [
                'invoice' => $invoiceNumber,
                'recipient_name' => $customerName,
                'recipient_phone' => $customerPhone,
                'recipient_address' => $customerAddress,
                'cod_amount' => $price
            ];

           $response = Http::withHeaders($header)->post($apiEndpoint,$payLoad);
           $jsonData = $response->json();

           if(isset($jsonData['consignment'])){
                $order->status = 'delivered';
                $order->consignment_id = $jsonData['consignment']['consignment_id'];
                $order->tracking_code = $jsonData['consignment']['tracking_link'];

                $order->save();
           }
        }
        elseif($order->courier_name == 'pathao'){
            
        }
        else{
            toastr()->error('Select a courier');
            return redirect()->back();
        }


        toastr()->success('Couirer entry is successful');
        return redirect()->back();

    }
}

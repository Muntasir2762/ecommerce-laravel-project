<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function addToCart (Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'qty' => 'required|min:1',
            'ip_address' => 'required|ip'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => true,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try{
            $product = Product::find($request->id);

            $cartProduct = Cart::where('product_id', $product->id)->where('ip_address', $request->ip_address)->first();

            if($cartProduct == null){
                $cart = new Cart();

                $cart->product_id = $product->id;
                $cart->color = $request->color;
                $cart->size = $request->size;
                $cart->qty = $request->qty;

                if($product->discount_price != null){
                    $cart->price = $product->discount_price;
                }
                else{
                    $cart->price = $product->regular_price;
                }

                $cart->ip_address = $request->ip_address;

                $cart->save();

                return response()->json([
                    'error' => false,
                    'message' => 'Added to Cart Successfully',
                    'cart' => $cart
                ], 200);
            }

            elseif($cartProduct != null){
                $cartProduct->color = $request->color;
                $cartProduct->size = $request->size;
                $cartProduct->qty = $request->qty;

                if($product->discount_price != null){
                    $cartProduct->price = $product->discount_price;
                }
                else{
                    $cartProduct->price = $product->regular_price;
                }            

                $cartProduct->save();

                return response()->json([
                    'error' => false,
                    'message' => 'Added to Cart Successfully',
                    'cart' => $cartProduct
                ], 200);
            }

        } catch(\Exception $e){
            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Add to Cart',
                'cart' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }

    }

    public function addToCartAuth (Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'qty' => 'required|min:1',
            'ip_address' => 'required|ip'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => true,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try{
            $product = Product::find($request->id);

            $cartProduct = Cart::where('product_id', $product->id)->where('ip_address', $request->ip_address)->first();

            if($cartProduct == null){
                $cart = new Cart();

                $cart->product_id = $product->id;
                $cart->color = $request->color;
                $cart->size = $request->size;
                $cart->qty = $request->qty;

                if($product->discount_price != null){
                    $cart->price = $product->discount_price;
                }
                else{
                    $cart->price = $product->regular_price;
                }

                $cart->ip_address = $request->ip_address;
                $cart->user_id = Auth::user()->id;

                $cart->save();

                return response()->json([
                    'error' => false,
                    'message' => 'Added to Cart Successfully',
                    'cart' => $cart
                ], 200);
            }

            elseif($cartProduct != null){
                $cartProduct->color = $request->color;
                $cartProduct->size = $request->size;
                $cartProduct->qty = $request->qty;

                if($product->discount_price != null){
                    $cartProduct->price = $product->discount_price;
                }
                else{
                    $cartProduct->price = $product->regular_price;
                }            

                $cartProduct->save();

                return response()->json([
                    'error' => false,
                    'message' => 'Added to Cart Successfully',
                    'cart' => $cartProduct
                ], 200);
            }

        } catch(\Exception $e){
            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Add to Cart',
                'cart' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }

    }

    public function deleteAddToCart ($id)
    {
        try{
            $cart = Cart::find($id);

            if($cart==null){
                return response()->json([
                    'error' => true,
                    'message' => 'No Data found',
                    'cart' => []
                ], 404);
            }

            $cart->delete();

            return response()->json([
                    'error' => false,
                    'message' => 'Cart Deleted Successfully',
                    'cart' => $cart
                ], 404);

        } catch(\Exception $e){
            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Delete Add to Cart',
                'cart' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getCartList ($ip_address)
    {
        if(!filter_var($ip_address, FILTER_VALIDATE_IP)){
            return response()->json([
                'error' => true,
                'message' => 'Invalid IP Address',
                'carts' => [],
            ], 422);
        }
        try {
            $carts = Cart::where('ip_address', $ip_address)->with('product')->get();
            $cartsCount = Cart::where('ip_address', $ip_address)->count();

            if($carts->isEmpty()){
                return response()->json([
                    'error' => true,
                    'message' => 'No Data Found',
                    'carts' => [],
                ], 404);
            }

            $subTotal=0;

            foreach($carts as $cart){
                $subTotal = $subTotal+$cart->price*$cart->qty;
            }

            $carts = [
                'cartCounts' => $cartsCount,
                'cartsPrice' => $subTotal,
                'cartProducts' => $carts
            ];
            return response()->json([
                'error' => false,
                'message' => 'Cart Data Retrived Successfully',
                'carts' => $carts,
            ], 200);

        } catch(\Exception $e){
            Log::error('Error Occured While Fetching Cart Data',[
                'ip_address'=>$ip_address,
                'exception'=>$e
            ]);
            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Delete Add to Cart',
                'carts' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function confirmOrder (Request $request)
    {
        $validator = Validator::make($request->all(),[
            'ip_address' => 'required|ip',
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string|min:20',
            'charge' => 'required|numeric',
            'price' => 'required|numeric',
            'products' => 'required|array',
            'products.*.id' =>'required|integer|exists:products,id',
            'products.*.qty' =>'required|integer',
            'products.*.price' =>'required|numeric',
            'products.*.color' =>'sometimes',
            'products.*.size' =>'sometimes',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => true,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try{
            DB::beginTransaction();

            $order = new Order();

            $order->ip_address = $request->ip_address;
            $previousOrder = Order::orderBy('id', 'desc')->first();

            if($previousOrder == null){
                $generatedInvoice = 'XYZ-1';
                $order->invoice_number = $generatedInvoice;
            }
            elseif($previousOrder != null){
                $generatedInvoice = 'XYZ-'.$previousOrder->id+1;
                $order->invoice_number = $generatedInvoice;
            }
            $order->name = $request->name;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->charge = $request->charge;
            $order->price = $request->price;

            $order->save();

            foreach($request->products as $productData){
                $orderDetails = new OrderDetails();

                $orderDetails->order_id = $order->id;
                $orderDetails->product_id = $productData['id'];
                $orderDetails->color = $productData['color'];
                $orderDetails->size = $productData['size'];
                $orderDetails->qty = $productData['qty'];
                $orderDetails->price = $productData['price'];

                $orderDetails->save();
            }

            Cart::where('ip_address', $request->ip_address)->delete();

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => 'Order has been placed successfully',
                'order' => $order,
            ], 200);

        } catch(\Exception $e){
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Placing Order',
                'order' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function confirmOrderAuth (Request $request)
    {
        $validator = Validator::make($request->all(),[
            'ip_address' => 'required|ip',
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string|min:20',
            'charge' => 'required|numeric',
            'price' => 'required|numeric',
            'products' => 'required|array',
            'products.*.id' =>'required|integer|exists:products,id',
            'products.*.qty' =>'required|integer',
            'products.*.price' =>'required|numeric',
            'products.*.color' =>'sometimes',
            'products.*.size' =>'sometimes',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => true,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try{
            DB::beginTransaction();

            $order = new Order();

            $order->ip_address = $request->ip_address;
            $order->user_id = Auth::user()->id;
            $previousOrder = Order::orderBy('id', 'desc')->first();

            if($previousOrder == null){
                $generatedInvoice = 'XYZ-1';
                $order->invoice_number = $generatedInvoice;
            }
            elseif($previousOrder != null){
                $generatedInvoice = 'XYZ-'.$previousOrder->id+1;
                $order->invoice_number = $generatedInvoice;
            }
            $order->name = $request->name;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->charge = $request->charge;
            $order->price = $request->price;

            $order->save();

            foreach($request->products as $productData){
                $orderDetails = new OrderDetails();

                $orderDetails->order_id = $order->id;
                $orderDetails->product_id = $productData['id'];
                $orderDetails->color = $productData['color'];
                $orderDetails->size = $productData['size'];
                $orderDetails->qty = $productData['qty'];
                $orderDetails->price = $productData['price'];

                $orderDetails->save();
            }

            Cart::where('ip_address', $request->ip_address)->delete();

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => 'Order has been placed successfully',
                'order' => $order,
            ], 200);

        } catch(\Exception $e){
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Placing Order',
                'order' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function successDetails ($invoice)
    {
        try{
            $order = Order::where('invoice_number', $invoice)->with('orderDetails')->first();

            if(!$order){
                return response()->json([
                    'error' => true,
                    'message' => 'No Data found',
                    'order' => []
                ], 404);
            }

            return response()->json([
                'error' => false,
                'message' => 'Order data retrived successfully',
                'order' => $order
            ], 200);


        } catch(\Exception $e){
            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Retriving Data',
                'order' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getOrders(Request $request)
    {
        try{
            if(isset($request->status)){
                $orders = Order::where('user_id', Auth::user()->id)->with('orderDetails')->where('status', $request->status)->paginate(10);
            }
            else{
                $orders = Order::where('user_id', Auth::user()->id)->with('orderDetails')->paginate(10);
            }

            if($orders->isEmpty()){
                return response()->json([
                    'error' => true,
                    'message' => 'No Data found',
                    'orders' => []
                ], 404);
            }

            return response()->json([
                'error' => false,
                'message' => 'Orders Retrived Successfully',
                'orders' => $orders
            ], 200);

        } catch(\Exception $e){
            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Retriving Data',
                'orders' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getOrderCount ()
    {
        try{
            $totalOrders = Order::where('user_id', Auth::user()->id)->count();
            $pendingOrders = Order::where('user_id', Auth::user()->id)->where('status', 'pending')->count();
            $confirmedOrders = Order::where('user_id', Auth::user()->id)->where('status', 'confirmed')->count();
            $deliveredOrders = Order::where('user_id', Auth::user()->id)->where('status', 'delivered')->count();
            $cancelledOrders = Order::where('user_id', Auth::user()->id)->where('status', 'cancelled')->count();
            $returnedOrders = Order::where('user_id', Auth::user()->id)->where('status', 'returned')->count();

            $count = [
                'total'   => $totalOrders,
                'pending' => $pendingOrders,
                'confirmed' => $confirmedOrders,
                'delivered' => $deliveredOrders,
                'cancelled' => $cancelledOrders,
                'returned' => $returnedOrders,
            ];

            return response()->json([
                'error' => false,
                'message' => 'Order Statistics Retrived Successfully',
                'orders' => $count
            ], 200);

        } catch(\Exception $e){
            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Retriving Data',
                'orders' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }
    }
}

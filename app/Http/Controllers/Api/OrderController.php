<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
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
}

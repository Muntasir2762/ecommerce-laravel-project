<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
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
}

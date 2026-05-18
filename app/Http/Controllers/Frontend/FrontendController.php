<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\WebsitePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index ()
    {
        $hotProducts = Product::where('status', 'active')->where('product_type', 'hot')->paginate(30);
        $newProducts = Product::where('status', 'active')->where('product_type', 'new')->paginate(30);
        $regularProducts = Product::where('status', 'active')->where('product_type', 'regular')->paginate(30);
        $discountProducts = Product::where('status', 'active')->where('product_type', 'discount')->paginate(30);
        $homeCategories = Category::get();
        return view('frontend.index', compact('hotProducts','newProducts','regularProducts','discountProducts','homeCategories'));
    }

    public function productDetails ($slug)
    {
        $product = Product::with('color','size','galleryImage','review')->where('slug',$slug)->first();
        $detailsPageCategory = Category::get();
        return view('frontend.product-details', compact('product','detailsPageCategory'));
    }

    public function addtocartDetailsPage (Request $request, $id)
    {
        
        $product = Product::find($id);

        $cartProduct = Cart::where('product_id', $product->id)->where('ip_address', $request->ip())->first();

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

            $cart->ip_address = $request->ip();
            
            if(Auth::check()){
                $cart->user_id = Auth::user()->id;
            }

            $cart->save();
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
        }

        toastr()->success('Product added to cart successfully');

        if($request->action == 'buyNow'){
            return redirect('/checkout');
        }
        else{
            return redirect()->back();
        }


    }

    public function addtocart (Request $request, $id)
    {
        $product = Product::find($id);

        $cartProduct = Cart::where('product_id', $product->id)->where('ip_address', $request->ip())->first();

        if($cartProduct == null){
            $cart = new Cart();

            $cart->product_id = $product->id;
            $cart->qty = 1;

            if($product->discount_price != null){
                $cart->price = $product->discount_price;
            }
            else{
                $cart->price = $product->regular_price;
            }

            $cart->ip_address = $request->ip();
            
            if(Auth::check()){
                $cart->user_id = Auth::user()->id;
            }

            $cart->save();
        }

        elseif($cartProduct != null){
            $cartProduct->qty = 1;

            if($product->discount_price != null){
                $cartProduct->price = $product->discount_price;
            }
            else{
                $cartProduct->price = $product->regular_price;
            }            

            $cartProduct->save();
        }

        toastr()->success('Product added to cart successfully');
        return redirect()->back();
    }

    public function deleCart ($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        
        return redirect()->back();
    }

    public function shopProducts ()
    {
        return view('frontend.shop');
    }

    public function privacyPolicy ()
    {
        $privacyPolicy = WebsitePolicy::select('privacy_policy')->first();
        return view('frontend.privacy-policy', compact('privacyPolicy'));
    }

    public function termsConditions ()
    {
        $termsConditions = WebsitePolicy::select('terms_conditions')->first();
        return view('frontend.terms-conditions', compact('termsConditions'));
    }

    public function refundPolicy ()
    {
        $refundPolicy = WebsitePolicy::select('refund_policy')->first();
        return view('frontend.refund-policy', compact('refundPolicy'));
    }

    public function paymentPolicy ()
    {
        $paymentPolicy = WebsitePolicy::select('payment_policy')->first();
        return view('frontend.payment-policy', compact('paymentPolicy'));
    }

    public function aboutUs ()
    {
        $aboutUs = WebsitePolicy::select('about_us')->first();
        return view('frontend.aboutus', compact('aboutUs'));
    }

    public function contactUs ()
    {
        return view('frontend.contactus');
    }

    public function contactMessageStore (Request $request)
    {
        $contactMessage = new ContactMessage();

        $contactMessage->name = $request->name;
        $contactMessage->phone = $request->phone;
        $contactMessage->email = $request->email;
        $contactMessage->subject = $request->subject;
        $contactMessage->message = $request->message;

        $contactMessage->save();
        
        toastr()->success('Message is sent successfully');
        return redirect()->back();
    }

    public function viewCart ()
    {
        return view('frontend.viewcart');
    }

    public function checkout ()
    {
        return view('frontend.checkout');
    }

    public function orderConfirmation ()
    {
        return view('frontend.thankyou');
    }

    public function categoryProducts ()
    {
        return view('frontend.category-products');
    }

    public function subCategoryProducts ()
    {
        return view('frontend.subcategory-products');
    }

    public function typeProducts ()
    {
        return view('frontend.type-products');
    }
}

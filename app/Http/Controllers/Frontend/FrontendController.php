<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\WebsitePolicy;
use Illuminate\Http\Request;

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

    public function productDetails ($id)
    {
        $product = Product::with('color','size','galleryImage','review')->where('id',$id)->first();
        $detailsPageCategory = Category::get();
        return view('frontend.product-details', compact('product','detailsPageCategory'));
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

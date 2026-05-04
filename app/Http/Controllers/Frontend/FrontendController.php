<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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
        return view('frontend.privacy-policy');
    }

    public function termsConditions ()
    {
        return view('frontend.terms-conditions');
    }

    public function refundPolicy ()
    {
        return view('frontend.refund-policy');
    }

    public function paymentPolicy ()
    {
        return view('frontend.payment-policy');
    }

    public function aboutUs ()
    {
        return view('frontend.aboutus');
    }

    public function contactUs ()
    {
        return view('frontend.contactus');
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

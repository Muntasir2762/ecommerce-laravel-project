<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function create ()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $subCategories = SubCategory::orderBy('name', 'asc')->get();
        return view('admin.product.create', compact('categories', 'subCategories'));
    }

    public function store (Request $request)
    {
    
        $request->validate([
            'name' => 'required|string|max:255',
            'sku_code' => 'nullable|unique:products,sku_code',
            'cat_id' => 'required|integer',
            'subcat_id'=> 'required|integer',
            'buying_price' => 'required',
            'regular_price' => 'required',
            'qty' => 'required|integer',
            'product_type' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:2048'
        ],[
            'name.required' => 'প্রোডাক্ট এর নাম জরুরি',
            'name.max' => 'প্রোডাক্ট এর নাম সর্বোচ্চ 255 ক্যারেক্টর!',
            'buying_price.required' => 'পণ্যের ক্রয় মূল্য জরুরি '
        ]);

        $product = new Product();

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->sku_code = $request->sku_code;
        $product->cat_id = $request->cat_id;
        $product->subcat_id = $request->subcat_id;
        $product->buying_price = $request->buying_price;
        $product->regular_price = $request->regular_price;
        $product->discount_price = $request->discount_price;
        $product->qty = $request->qty;
        $product->product_type = $request->product_type;
        $product->description = $request->description;
        $product->product_policy = $request->product_policy;

        if(isset($request->image)){
            $image = $request->file('image');
            $imageName = rand().'.'.$image->getClientOriginalExtension(); //4347657.jpg
            $image->move('admin/product', $imageName);

            $product->image = url('admin/product/'.$imageName); //http://127.0.0.1:8000/admin/category/4347657.jpg
        }

        $product->save();

        toastr()->success('Product created successfully');
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function create ()
    {
        return view('admin.category.create');
    }

    public function store (Request $request)
    {
        $category = new Category();

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        if(isset($request->image)){
            $image = $request->file('image');
            $imageName = rand().'.'.$image->getClientOriginalExtension(); //4347657.jpg
            $image->move('admin/category', $imageName);

            $category->image = url('admin/category/'.$imageName); //http://127.0.0.1:8000/admin/category/4347657.jpg
        }

        $category->save();

        toastr()->success('Category created successfully');
        return redirect()->back();

    }
}

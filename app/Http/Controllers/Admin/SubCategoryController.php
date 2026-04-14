<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function create ()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.subcategory.create', compact('categories'));
    }

    public function store (Request $request)
    {
        $subCategory = new SubCategory();

        $subCategory->cat_id = $request->cat_id;
        $subCategory->name = $request->name;
        $subCategory->slug = Str::slug($request->name);

        $subCategory->save();

        toastr()->success('SubCategory created successfully');
        return redirect()->back();
    }

    public function list ()
    {
        $subCategories = SubCategory::with('category')->get();
        return view('admin.subcategory.list', compact('subCategories'));
    }

    public function edit ($id)
    {
        $subCategory = SubCategory::find($id);
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.subcategory.edit', compact('categories', 'subCategory'));
    }

    public function update (Request $request, $id)
    {
        $subCategory = SubCategory::find($id);

        $subCategory->cat_id = $request->cat_id;
        $subCategory->name = $request->name;
        $subCategory->slug = Str::slug($request->name);

        $subCategory->save();

        toastr()->success('SubCategory updated successfully');
        return redirect('manage/subcategory-list');
    }

    public function delete ($id)
    {
        $subCategory = SubCategory::find($id);

        $subCategory->delete();

        toastr()->success('SubCategory deleted successfully');
        return redirect()->back();
    }
}

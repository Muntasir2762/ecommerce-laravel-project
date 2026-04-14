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

    public function list ()
    {
        $categories = Category::get();
        return view('admin.category.list', compact('categories'));
    }

    public function edit ($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update (Request $request, $id)
    {
        $category = Category::find($id);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        if(isset($request->image)){

            if($category->image && file_exists('admin/category/'.basename($category->image))){
                unlink('admin/category/'.basename($category->image));
            }

            $image = $request->file('image');
            $imageName = rand().'.'.$image->getClientOriginalExtension(); //4347657.jpg
            $image->move('admin/category', $imageName);

            $category->image = url('admin/category/'.$imageName); //http://127.0.0.1:8000/admin/category/4347657.jpg
        }

        $category->save();

        toastr()->success('Category updated successfully');
        return redirect('/manage/category-list');
    }

    public function delete ($id)
    {
        $category = Category::find($id);

        if($category->image && file_exists('admin/category/'.basename($category->image))){
            unlink('admin/category/'.basename($category->image));
        }

        $category->delete();

        toastr()->success('Category deleted successfully');
        return redirect()->back();

    }
}

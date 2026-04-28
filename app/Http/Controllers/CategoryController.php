<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// use App\Models\Admin\Category;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        return view('frontend.pages.category.index',[
            'categories' => Category::paginate(10),
        ]);
    }


    public function create_category_button()
    {
        return view('frontend.pages.category.create_category_button'); 
    }


    public function category_store(Request $request)
    {


        $request->validate([
            'category_name'  => 'required|string|max:255|unique:categories,category_name',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);


        Category::newCategory($request);
        return back()->with('message', 'Category info create successfully!');
    }


    public function edit($id)
    {
        return view('frontend.pages.category.edit', [
            'category' => Category::find($id)
        ]);
    }



    public function updateCategory(Request $request, $id)
    {

        $request->validate([
            'category_name'  => 'required|string|max:255|unique:categories,category_name',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);



        Category::updateCategory($request, $id);
        return redirect('/product/category')->with('message', 'Category info update successfully!');
    }


    public function delete($id)
    {
        Category::deleteCategory($id);
        return redirect('/product/category');
    }


}

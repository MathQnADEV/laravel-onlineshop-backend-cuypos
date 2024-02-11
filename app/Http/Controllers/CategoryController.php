<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view("pages.categories.index", compact("categories"));
    }

    public function create()
    {
        return view("pages.categories.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "image" => "required|image|mimes:png,jpg,jpeg,giv|max:2048",
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        if ($request->hasFile("image")) {
            $image = $request->file("image");
            $image->storeAs('public/categories', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category Created Successfully');
    }

    public function show($id)
    {
        return view('pages.categories.show');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('pages.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required",
            "image" => "nullable|image|mimes:png,jpg,jpeg,giv|max:2048",
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        if ($request->hasFile("image")) {
            Storage::disk("local")->delete($category->image);
            $image = $request->file("image");
            $image->storeAs('public/categories', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category Updated Successfully');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category Deleted Successfully');
    }
}

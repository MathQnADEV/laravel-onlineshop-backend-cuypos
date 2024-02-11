<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::when($request->input('name'), function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view("pages.products.index", compact("products"));
    }

    public function create()
    {
        $categories = Category::get();
        return view("pages.products.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "description" => "required",
            "price" => "required|numeric",
            "category_id" => "required",
            "stock" => "required|numeric",
            "status" => "required|boolean",
            "is_favorite" => "required|boolean",
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->stock = $request->stock;
        $product->status = $request->status;
        $product->is_favorite = $request->is_favorite;

        $product->save();

        if ($request->hasFile("image")) {
            $image = $request->file("image");
            $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        return redirect()->route("products.index")->with("success", "Product Created Successfully");
    }

    public function show($id)
    {
        return view('pages.products.show');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::get();
        return view('pages.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required",
            "description" => "required",
            "price" => "required|numeric",
            "category_id" => "required",
            "stock" => "required|numeric",
            "status" => "required|boolean",
            "is_favorite" => "required|boolean",
            'image' => 'image|mimes:png,jpg,jpeg'
        ]);

        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->status = $request->status;
        $product->stock = $request->stock;
        $product->is_favorite = $request->is_favorite;
        $product->save();

        if ($request->hasFile("image")) {
            Storage::disk("local")->delete($product->image);
            $image = $request->file("image");
            $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        return redirect()->route("products.index")->with("success", "Product Updated Successfully");
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route("products.index")->with("success", "Product Deleted Successfully");
    }
}

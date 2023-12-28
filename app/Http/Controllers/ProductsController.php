<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = new Products([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
        ]);
        if ($request->hasFile('image')) {
            $imageFolder = 'product_images';
            Storage::makeDirectory($imageFolder);
            $imagePath = $request->file('image')->store($imageFolder, 'public');
            $product->image = $imagePath;
        }
        $product->save();
        return redirect()->route('products')->with('success', 'Product added successfully');
    }

    public function getProducts(){
        $products = Products::all();
        return view('products', compact('products'));
    }
}

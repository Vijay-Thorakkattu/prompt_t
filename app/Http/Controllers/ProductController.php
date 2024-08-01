<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class ProductController extends Controller
{
    //

    public function index()
    {
     
        $products = Product::with('vendor')
                            ->orderBy('id', 'desc')
                            ->paginate(10); 
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $vendors = User::role('vendor')->get();
        return view('products.create', compact('vendors'));
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'vendor_id' => 'nullable', 
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $vendorId = $request->input('vendor_id') ?? auth()->id();
    
        $productData = $request->except('image');
        $productData['vendor_id'] = $vendorId; 
    
        $product = new Product($productData);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/products', 'public');
            $product->image = $imagePath;
        }

        $product->save();
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }
    public function edit(Product $product)
    {
        $vendors = User::role('vendor')->get();

        return view('products.edit', compact('product', 'vendors'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'vendor_id' => 'nullable',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        $product = Product::findOrFail($id);
    
        $vendorId = $request->input('vendor_id') ?? auth()->id();
    
        $product->fill($request->except('image'));
        $product->vendor_id = $vendorId; 
    
        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }
    
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
    
    public function destroy($id)
    {

        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function getProductPrice($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json(['price' => $product->price]);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
}

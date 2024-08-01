<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;

class StockController extends Controller
{
    //
    public function index()
    {
        $stocks = Stock::with('product')
                        ->orderBy('id', 'desc') 
                        ->paginate(10);
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stocks.create', compact('products'));
    }

    public function store(Request $request)
    {
      
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $existingStock = Stock::where('product_id', $request->product_id)->first();

        if ($existingStock) {
            return redirect()->back()->withErrors(['product_id' => 'Stock for this product already exists.'])->withInput();
        }
    

        Stock::create($request->all());

        return redirect()->route('stocks.index')->with('success', 'Stock created successfully.');
    }

    public function edit(Stock $stock)
    {
        $product = Product::find($stock->product_id);
        $products =Product::all();
        return view('stocks.edit', compact('stock', 'products','product'));
    }

    public function update(Request $request, Stock $stock)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $stock->update($request->all());

        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully.');
    }


}

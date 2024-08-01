<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    //

    public function addToCart($id)
    {

       $product = Product::find($id);
        if(!$product) {

            abort(404);

        }

        $cart = session()->get('cart');

        if(!$cart) {

            $cart = [
                    $id => [                        
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $product->price,
                        "image" => $product->image,
                    ]
            ];

            session()->put('cart', $cart);            
            return count(session('cart'));

        }

          if(isset($cart[$id])) {

            $cart[$id]['quantity']++;

            $updatedCart = $cart;
            session()->forget('cart');
            session()->put('cart', $updatedCart);
            return count(session('cart'));

        }

         $cart[$id] = [            
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->image,
        ];

        session()->put('cart', $cart);

        return count(session('cart'));

    }

    public function cart(){

       return view('user.cart');
    }

    public function updateCart(Request $request)
    { 
         
        if ($request->name && $request->quantity) {

            $cart = session()->get('cart', []);
            $ProductTotalPrice = 0;
            foreach ($cart as $id => $details) {
                if ($details['name'] === $request->name) {

                    $cart[$id]['quantity'] = $request->quantity;
                    $ProductTotalPrice = $cart[$id]['quantity'] * $cart[$id]['price'];
    
                    session()->put('cart', $cart);
        
                    return response()->json(['success' => true, 'newPrice' => $ProductTotalPrice]);
                }
            }
        
            return response()->json(['success' => false, 'message' => 'Product not found in cart']);
        }
        
    }

    public function remove(Request $request)
    {
        
        if ($request->name) {
            $cart = session()->get('cart', []);
            
            foreach ($cart as $id => $details) {
                if ($details['name'] === $request->name) {
                    unset($cart[$id]);
                    session()->put('cart', $cart);
    
                    $count = count($cart);
    
                    return response()->json(['success' => true, 'count' => $count]);
                }
            }
    
            return response()->json(['success' => false, 'message' => 'Product not found in cart']);
        }
    
        return response()->json(['success' => false, 'message' => 'Product name is required']);
    }
    
}

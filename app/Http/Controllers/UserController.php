<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;

class UserController extends Controller
{
    //

    public function index(Request $request){

        $products = Product::orderBy('id', 'desc')->get(); 
        return view('user.index', compact('products'));
    }
}

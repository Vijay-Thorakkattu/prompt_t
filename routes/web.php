<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
//     // return view('login');
// });

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    } else {
        return redirect()->route('login');
    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin/home', [AdminController::class, 'home'])->name('admin.home');
    Route::get('admin/vendors/create', [VendorController::class, 'create'])->name('vendors.create');
    Route::post('admin/vendors/store', [VendorController::class, 'store'])->name('vendors.store');
    Route::get('admin/vendors/index', [VendorController::class, 'index'])->name('vendors.index');
    Route::get('admin/vendors/{id}/edit', [VendorController::class, 'edit'])->name('vendors.edit');
    Route::put('admin/vendors/{id}', [VendorController::class, 'update'])->name('vendors.update');
    Route::delete('admin/vendors/{id}', [VendorController::class, 'destroy'])->name('vendors.destroy');
   
});

Route::resource('/products', ProductController::class);
Route::resource('vendors/stocks', StockController::class);

Route::group(['middleware' => ['role:vendor']], function () {
    Route::get('/vendor/home', [AdminController::class, 'home'])->name('vendor.home');
});

Route::group(['middleware' => ['role:user']], function () {
    Route::get('view', [UserController::class, 'index'])->name('user.home');
    Route::get('cart.listing', [CartController::class, 'cart'])->name('cart.listing');
    
});
Route::get('/api/product/{id}', [ProductController::class, 'getProductPrice']);
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart']);
Route::patch('/update-cart', [CartController::class, 'updateCart']);
Route::delete('/remove-from-cart', [CartController::class, 'remove']);



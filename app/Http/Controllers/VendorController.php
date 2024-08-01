<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    //

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

        $user->assignRole('vendor');

        return redirect()->route('vendors.index')->with('success', 'Vendor created successfully!');
    }


    public function index()
    {
        $vendors = User::role('vendor')
                        ->orderBy('id', 'desc')
                        ->paginate(10);
        return view('vendors.index', compact('vendors'));
    }

    public function edit($id)
    {
        $vendor = User::findOrFail($id);
        return view('vendors.edit', compact('vendor'));
    }


    public function update(Request $request, User $vendor, $id)
    {
        $vendor = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $vendor->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $vendor->name = $request->name;
        $vendor->email = $request->email;
        
        if ($request->filled('password')) {
            $vendor->password = Hash::make($request->password);
        }

        $vendor->save();

        return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully.');
    }

    public function destroy($id)
    {
        // dd($id);
        $vendor = User::findOrFail($id);
        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully');
    }

}

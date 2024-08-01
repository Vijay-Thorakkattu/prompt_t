@extends('admin.mainlayout.layout')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')
@php
    $user = auth()->user();
@endphp
@section('content')
    <div class="container">
        <h1>Edit Product</h1>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if ($user->hasRole('admin'))
            <div class="form-group">
                <label for="vendor_id">Vendor</label>
                <select id="vendor_id" name="vendor_id" class="form-control" required>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ $vendor->id == $product->vendor_id ? 'selected' : '' }}>
                            {{ $vendor->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" class="form-control">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="mt-2" width="150" alt="Product Image">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
@endsection
``

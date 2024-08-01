@extends('admin.mainlayout.layout')

@section('title', 'Add Product')
@section('page-title', 'Add New Product')

@section('content')
@php
    $user = auth()->user();
@endphp
    <div class="container">
        <h1>Add Product</h1>
        
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
        
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($user->hasRole('admin'))
            <div class="form-group">
                <label for="vendor_id">Vendor</label>
                <select id="vendor_id" name="vendor_id" class="form-control" required>
                    <option value="">Select Vendor</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
